<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Courrier;
use App\Models\CourrierHistorique;
use App\Models\Departement;
use App\Models\TypeCourrier;
use App\Models\User;
use App\Notifications\NouveauCourrierNotification;
use App\Notifications\CourrierDistribueNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class CourrierController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type');

        $query = Courrier::with(['user', 'departement']);

        if ($type) {
            $query->where('type', $type);
        }

        if ($user->departement_id && !$user->hasPermission('voir_tous_courriers')) {
            $query->where('departement_id', $user->departement_id);
        }

        $courriers = $query->orderBy('created_at', 'desc')->paginate(15);
        $departements = Departement::all();

        return view('courriers.index', compact('courriers', 'departements', 'type'));
    }

    public function aReceptionner()
    {
        $user = Auth::user();
        
        if (!$user->hasPermission('receptionner_courrier')) {
            abort(403, 'Accès non autorisé : Permission manquante.');
        }

        $query = Courrier::with(['user', 'departement'])
            ->where('statut', 'en_attente_reception');

        if ($user->departement_id && !$user->hasPermission('voir_tous_courriers')) {
            $query->where('departement_id', $user->departement_id);
        }

        $courriers = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('courriers.a-receptionner', compact('courriers'));
    }

    public function historique(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type');
        $statut = $request->get('statut');
        $search = $request->get('search');
        
        $query = Courrier::with(['user', 'departement']);

        if ($type) $query->where('type', $type);
        if ($statut) $query->where('statut', $statut);
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('objet', 'like', "%{$search}%")
                  ->orWhere('numero_enregistrement', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        if ($user->departement_id && !$user->hasPermission('voir_tous_courriers')) {
            $query->where('departement_id', $user->departement_id);
        }

        $courriers = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('courriers.historique', compact('courriers'));
    }
    public function create(Request $request) // <-- Ajoute Request $request ici
    {
        if (!Auth::user()->hasPermission('creer_courrier')) {
            abort(403, 'Accès non autorisé : Permission manquante.');
        }
        
        $departements = Departement::all();
        $typesCourrier = TypeCourrier::where('actif', true)->get();
        
        // ✅ Récupère l'ID du courrier arrivé lié s'il existe dans l'URL (?lie_a=X)
        $lieA = $request->get('lie_a');
        
        return view('courriers.create', compact('departements', 'typesCourrier', 'lieA'));
    }

    public function scanUpload(Request $request)
    {
        if (!Auth::user()->hasPermission('scan_documents')) {
            abort(403, 'Vous n\'avez pas la permission de numériser des documents.');
        }

        $request->validate([
            'fichier_scanne' => 'required|file|mimes:pdf,jpg,jpeg,png|max:204800',
        ]);

        $path = $request->file('fichier_scanne')->store('scans_courriers', 'public');

        return redirect()->route('courriers.create')
            ->with('success', 'Document numérisé avec succès ! Veuillez compléter les informations du courrier.')
            ->with('fichier_scanne_path', $path);
    }

     public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('creer_courrier')) {
            abort(403, 'Accès non autorisé : Permission manquante.');
        }

        // ✅ NORMALISATION DU TYPE POUR ÉVITER LES ERREURS DE VALIDATION
        if ($request->filled('type')) {
            $request->merge([
                'type' => strtolower(str_replace(['é', 'è', 'ê'], 'e', $request->input('type')))
            ]);
        }

        $userRole = Auth::user()->role;
        $allowedTypes = ['arrivee', 'depart', 'interne'];
        if (in_array($userRole, ['directeur', 'secretaire'])) {
            $allowedTypes = ['depart', 'interne'];
        }

        $validated = $request->validate([
            'type' => ['required', Rule::in($allowedTypes)],
            'sous_type' => 'nullable|string',
            'objet' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            
            'expediteur' => 'nullable|string|max:255',
            'expediteur_nom' => 'nullable|string|max:255',
            'expediteur_dept_id' => 'nullable|exists:departements,id',
            
            'destinataire' => 'nullable|string|max:255',
            'destinataire_nom' => 'nullable|string|max:255',
            'destinataire_nom_fonction' => 'nullable|string|max:255',
            'destinataire_structure' => 'nullable|string|max:255',
            'destinataire_ville_adresse' => 'nullable|string|max:255',
            'destinataire_dept_id' => 'nullable|exists:departements,id',
            
            'departement_id' => 'nullable|exists:departements,id',
            'contenu' => 'nullable|string',
            'fichier_scanne' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:204800',
            'fichier_scanne_path' => 'nullable|string',
            
            'date_arrivee' => 'nullable|date',
            'heure_arrivee' => 'nullable|string',
            'date_courrier_expediteur' => 'nullable|date',
            'type_document' => 'nullable|string|max:50',
            'nombre_pieces_jointes' => 'nullable|integer|min:1',
            'necessite_reponse' => 'nullable|boolean',
            'priorite' => 'nullable|string|in:normal,urgent',
            
            'signataire_nom' => 'nullable|string|max:255',
            'signataire_fonction' => 'nullable|string|max:255',
            'date_transmission' => 'nullable|date',
            'priorite_envoi' => 'nullable|string|in:normal,urgent',
            'mode_envoi_effectif' => 'nullable|string',
            'date_envoi_physique' => 'nullable|date',
            'numero_suivi' => 'nullable|string|max:100',
            'ar_recu' => 'nullable|boolean',
            'date_reception_ar' => 'nullable|date',
            'fichier_ar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:204800',
            
            'date_enregistrement' => 'nullable|date',
            'heure_enregistrement' => 'nullable',
            'date_envoi' => 'nullable|date',
            'heure_envoi' => 'nullable',
            'date_validation' => 'nullable|date',
            'heure_validation' => 'nullable',
            'date_reception' => 'nullable|date',
            'heure_reception' => 'nullable',
                        // Ajoute cette ligne dans les règles de validation de store et storeAndSend
            'courrier_arrive_lie_id' => 'nullable|exists:courriers,id',
        ]);

        $year = date('Y');
        $typeCourrier = TypeCourrier::where('nom', ucfirst($validated['type']))->first() 
                        ?? TypeCourrier::whereRaw('LOWER(REPLACE(nom, "é", "e")) = ?', [$validated['type']])->first();
                        
        $prefix = $typeCourrier ? $typeCourrier->prefixe : 'GEN';
        $count = Courrier::where('type', $validated['type'])->whereYear('created_at', $year)->count() + 1;
        $validated['numero_enregistrement'] = $prefix . '-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        if ($request->hasFile('fichier_scanne')) {
            $validated['fichier_scanne'] = $request->file('fichier_scanne')->store('scans_courriers', 'public');
        } elseif ($request->filled('fichier_scanne_path')) {
            $validated['fichier_scanne'] = $request->input('fichier_scanne_path');
        }

        if ($request->hasFile('fichier_ar')) {
            $validated['fichier_ar'] = $request->file('fichier_ar')->store('ar_courriers', 'public');
        }

        $validated['expediteur'] = $validated['expediteur_nom'] ?? $validated['expediteur'] ?? 'Non spécifié';
        $validated['destinataire'] = $validated['destinataire_nom_fonction'] ?? $validated['destinataire_nom'] ?? $validated['destinataire'] ?? 'Non spécifié';
        
        if ($validated['type'] === 'arrivee') {
            $validated['departement_id'] = $validated['destinataire_dept_id'] ?? $validated['departement_id'] ?? null;
        } else {
            $validated['departement_id'] = $validated['expediteur_dept_id'] ?? $validated['departement_id'] ?? null;
        }

        // ✅ CORRECTION : On retire les champs qui n'existent pas encore dans la base de données
        $fieldsToRemove = [
            'expediteur_nom', 'expediteur_dept_id', 'destinataire_nom', 'destinataire_dept_id',
            'date_enregistrement', 'heure_enregistrement', 'date_envoi', 'heure_envoi',
            'date_validation', 'heure_validation', 'date_reception', 'heure_reception'
        ];
        foreach ($fieldsToRemove as $field) {
            unset($validated[$field]);
        }

        $validated['statut'] = 'enregistre';
        $validated['user_id'] = Auth::id();

        $nouveauCourrier = Courrier::create($validated);

        AuditLog::logAction('create', 'Création du courrier N° ' . $nouveauCourrier->numero_enregistrement, $nouveauCourrier);

        return redirect()->route('courriers.index')->with('success', 'Courrier enregistré avec succès sous le N° ' . $nouveauCourrier->numero_enregistrement . ' !');
    }

    public function storeAndSend(Request $request)
    {
        if (!Auth::user()->hasPermission('creer_courrier')) {
            abort(403, 'Accès non autorisé : Permission manquante.');
        }

        if ($request->filled('type')) {
            $request->merge([
                'type' => strtolower(str_replace(['é', 'è', 'ê'], 'e', $request->input('type')))
            ]);
        }

        $userRole = Auth::user()->role;
        $allowedTypes = ['arrivee', 'depart', 'interne'];
        if (in_array($userRole, ['directeur', 'secretaire'])) {
            $allowedTypes = ['depart', 'interne'];
        }

        $validated = $request->validate([
            'type' => ['required', Rule::in($allowedTypes)],
            'sous_type' => 'nullable|string',
            'objet' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            
            'expediteur' => 'nullable|string|max:255',
            'expediteur_nom' => 'nullable|string|max:255',
            'expediteur_dept_id' => 'nullable|exists:departements,id',
            
            'destinataire' => 'nullable|string|max:255',
            'destinataire_nom' => 'nullable|string|max:255',
            'destinataire_nom_fonction' => 'nullable|string|max:255',
            'destinataire_structure' => 'nullable|string|max:255',
            'destinataire_ville_adresse' => 'nullable|string|max:255',
            'destinataire_dept_id' => 'nullable|exists:departements,id',
            
            'departement_id' => 'nullable|exists:departements,id',
            'contenu' => 'nullable|string',
            'fichier_scanne' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:204800',
            'fichier_scanne_path' => 'nullable|string',
            
            'date_arrivee' => 'nullable|date',
            'heure_arrivee' => 'nullable|string',
            'date_courrier_expediteur' => 'nullable|date',
            'type_document' => 'nullable|string|max:50',
            'nombre_pieces_jointes' => 'nullable|integer|min:1',
            'necessite_reponse' => 'nullable|boolean',
            'priorite' => 'nullable|string|in:normal,urgent',
            
            'signataire_nom' => 'nullable|string|max:255',
            'signataire_fonction' => 'nullable|string|max:255',
            'date_transmission' => 'nullable|date',
            'priorite_envoi' => 'nullable|string|in:normal,urgent',
            'mode_envoi_effectif' => 'nullable|string',
            'date_envoi_physique' => 'nullable|date',
            'numero_suivi' => 'nullable|string|max:100',
            'ar_recu' => 'nullable|boolean',
            'date_reception_ar' => 'nullable|date',
            'fichier_ar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:204800',
            
            'date_enregistrement' => 'nullable|date',
            'heure_enregistrement' => 'nullable',
            'date_envoi' => 'nullable|date',
            'heure_envoi' => 'nullable',
            'date_validation' => 'nullable|date',
            'heure_validation' => 'nullable',
            'date_reception' => 'nullable|date',
            'heure_reception' => 'nullable',
            // Ajoute cette ligne dans les règles de validation de store et storeAndSend
            'courrier_arrive_lie_id' => 'nullable|exists:courriers,id',
        ]);

        $year = date('Y');
        $typeCourrier = TypeCourrier::where('nom', ucfirst($validated['type']))->first() 
                        ?? TypeCourrier::whereRaw('LOWER(REPLACE(nom, "é", "e")) = ?', [$validated['type']])->first();
                        
        $prefix = $typeCourrier ? $typeCourrier->prefixe : 'GEN';
        $count = Courrier::where('type', $validated['type'])->whereYear('created_at', $year)->count() + 1;
        $validated['numero_enregistrement'] = $prefix . '-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        if ($request->hasFile('fichier_scanne')) {
            $validated['fichier_scanne'] = $request->file('fichier_scanne')->store('scans_courriers', 'public');
        } elseif ($request->filled('fichier_scanne_path')) {
            $validated['fichier_scanne'] = $request->input('fichier_scanne_path');
        }

        if ($request->hasFile('fichier_ar')) {
            $validated['fichier_ar'] = $request->file('fichier_ar')->store('ar_courriers', 'public');
        }

        $validated['expediteur'] = $validated['expediteur_nom'] ?? $validated['expediteur'] ?? 'Non spécifié';
        $validated['destinataire'] = $validated['destinataire_nom_fonction'] ?? $validated['destinataire_nom'] ?? $validated['destinataire'] ?? 'Non spécifié';
        
        if ($validated['type'] === 'arrivee') {
            $validated['departement_id'] = $validated['destinataire_dept_id'] ?? $validated['departement_id'] ?? null;
        } else {
            $validated['departement_id'] = $validated['expediteur_dept_id'] ?? $validated['departement_id'] ?? null;
        }

        // ✅ CORRECTION : On retire les champs qui n'existent pas encore dans la base de données
        $fieldsToRemove = [
            'expediteur_nom', 'expediteur_dept_id', 'destinataire_nom', 'destinataire_dept_id',
            'date_enregistrement', 'heure_enregistrement', 'date_envoi', 'heure_envoi',
            'date_validation', 'heure_validation', 'date_reception', 'heure_reception'
        ];
        foreach ($fieldsToRemove as $field) {
            unset($validated[$field]);
        }

        $validated['statut'] = 'enregistre';
        $validated['user_id'] = Auth::id();

        $nouveauCourrier = Courrier::create($validated);

        AuditLog::logAction('send', 'Création et envoi du courrier N° ' . $nouveauCourrier->numero_enregistrement, $nouveauCourrier);

        return redirect()->route('courriers.index')
            ->with('success', 'Courrier enregistré et envoyé avec succès sous le N° ' . $nouveauCourrier->numero_enregistrement . ' !');
    }

    public function show(Courrier $courrier)
    {
        $courrier->load(['user', 'departement']);
        return view('courriers.show', compact('courrier'));
    }

    public function edit(Courrier $courrier)
    {
        $departements = Departement::all();
        return view('courriers.edit', compact('courrier', 'departements'));
    }

    public function update(Request $request, Courrier $courrier)
    {
        $validated = $request->validate([
            'sous_type' => 'nullable|string',
            'reference' => 'required|string|max:255',
            'objet' => 'required|string|max:255',
            'contenu' => 'nullable|string',
            'destinataire' => 'nullable|string|max:255',
            
            'date_enregistrement' => 'nullable|date',
            'heure_enregistrement' => 'nullable',
            'date_envoi' => 'nullable|date',
            'heure_envoi' => 'nullable',
            'date_validation' => 'nullable|date',
            'heure_validation' => 'nullable',
            'date_reception' => 'nullable|date',
            'heure_reception' => 'nullable',
            
            'date_arrivee' => 'nullable|date',
            'heure_arrivee' => 'nullable|string',
            'date_courrier_expediteur' => 'nullable|date',
            'type_document' => 'nullable|string|max:50',
            
            'destinataire_nom_fonction' => 'nullable|string|max:255',
            'destinataire_structure' => 'nullable|string|max:255',
            'destinataire_ville_adresse' => 'nullable|string|max:255',
            'signataire_nom' => 'nullable|string|max:255',
            'signataire_fonction' => 'nullable|string|max:255',
            'mode_envoi_effectif' => 'nullable|string',
            'transmis_standardiste' => 'nullable|boolean',
            
            'nombre_pieces_jointes' => 'nullable|integer|min:1',
            'necessite_reponse' => 'nullable|boolean',
            'priorite' => 'nullable|string|in:normal,urgent',
        ]);

        $courrier->update($validated);
        AuditLog::logAction('update', 'Modification du courrier N° ' . $courrier->numero_enregistrement, $courrier);

        return redirect()->route('courriers.show', $courrier)->with('success', 'Courrier mis à jour avec succès !');
    }

    public function destroy(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('supprimer_courrier')) {
            return redirect()->back()->with('error', '⚠️ Vous n\'avez pas la permission de supprimer ce courrier.');
        }

        if (!$courrier->canBeDeleted()) {
            return redirect()->back()->with('error', '⚠️ Impossible de supprimer ce courrier : il a déjà été envoyé dans le circuit de traitement.');
        }

        $courrier->delete();
        return redirect()->route('courriers.index')->with('success', 'Courrier supprimé avec succès.');
    }

    public function distribuer(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('distribuer_courrier')) {
            abort(403, 'Accès non autorisé : Permission manquante.');
        }
        $courrier->load(['user', 'departement']);
        $departements = Departement::all();
        return view('courriers.distribuer', compact('courrier', 'departements'));
    }

    public function traiterDistribution(Request $request, Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('distribuer_courrier')) {
            abort(403, 'Accès non autorisé : Permission manquante.');
        }

        $validated = $request->validate([
            'departement_id' => 'required|exists:departements,id',
            'note_distribution' => 'nullable|string|max:500',
        ]);

        $departement = Departement::find($validated['departement_id']);

        $courrier->update([
            'departement_id' => $validated['departement_id'],
            'destinataire' => $departement->nom,
            'statut' => 'en_attente_reception', 
            'contenu' => $validated['note_distribution'] ? $courrier->contenu . "\n\n--- Note de distribution ---\n" . $validated['note_distribution'] : $courrier->contenu,
        ]);

        AuditLog::logAction('distribute', 'Distribution du courrier N° ' . $courrier->numero_enregistrement . ' au département ' . $departement->nom, $courrier);

        $usersToNotify = User::where('departement_id', $validated['departement_id'])
                             ->whereIn('role', ['secretaire', 'directeur'])
                             ->get();
        foreach ($usersToNotify as $user) {
            $user->notify(new CourrierDistribueNotification($courrier));
        }

        return redirect()->route('courriers.index')->with('success', 'Courrier N° ' . $courrier->numero_enregistrement . ' distribué au département ' . $departement->nom . ' avec succès !');
    }

    public function receptionner(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('receptionner_courrier')) {
            abort(403, 'Accès non autorisé : Permission manquante.');
        }
        
        if ($courrier->departement_id !== Auth::user()->departement_id) {
            abort(403, 'Ce courrier n\'est pas destiné à votre département.');
        }
        
        $courrier->update([
            'statut' => 'receptionne',
            'date_reception' => now(),
        ]);
        
        if (class_exists('App\Models\CourrierHistorique')) {
            CourrierHistorique::create([
                'courrier_id' => $courrier->id,
                'user_id' => Auth::id(),
                'action' => 'receptionne',
                'commentaire' => 'Courrier réceptionné',
            ]);
        }
        
        AuditLog::logAction('receptionne', 'Réception du courrier N° ' . $courrier->numero_enregistrement, $courrier);
        
        return redirect()->back()->with('success', 'Courrier réceptionné avec succès !');
    }

    public function envoyerDirection(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('envoyer_courrier')) {
            abort(403, 'Accès non autorisé : Permission manquante.');
        }
        
        $directeur = User::where('role', 'directeur')
            ->where('is_active', true)
            ->first();
        
        if (!$directeur) {
            return back()->with('error', 'Aucun directeur actif trouvé dans le système.');
        }
        
        $courrier->update([
            'statut' => 'en_attente_decision',
            'user_id' => $directeur->id,
            'departement_id' => $directeur->departement_id,
            'date_envoi_direction' => now(),
        ]);
        
        if (class_exists('App\Models\CourrierHistorique')) {
            CourrierHistorique::create([
                'courrier_id' => $courrier->id,
                'user_id' => Auth::id(),
                'action' => 'envoye_direction',
                'commentaire' => 'Envoyé au directeur pour décision',
            ]);
        }

        AuditLog::logAction('envoye_direction', 'Envoi à la direction du courrier N° ' . $courrier->numero_enregistrement, $courrier);
        
        $directeur->notify(new NouveauCourrierNotification($courrier));
        
        return redirect()->back()->with('success', 'Courrier envoyé au directeur avec succès !');
    }

    public function traiter(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('traiter_courrier')) {
            abort(403, 'Accès non autorisé : Permission manquante.');
        }

        $courrier->update([
            'statut' => 'traite',
            'date_traitement' => now(),
        ]);

        if (class_exists('App\Models\CourrierHistorique')) {
            CourrierHistorique::create([
                'courrier_id' => $courrier->id,
                'user_id' => Auth::id(),
                'action' => 'traite',
                'commentaire' => 'Courrier traité et validé',
            ]);
        }

        AuditLog::logAction('traite', 'Traitement du courrier N° ' . $courrier->numero_enregistrement, $courrier);

        return redirect()->back()->with('success', 'Courrier traité avec succès !');
    }

    /* ==========================================
     * ✨ WORKFLOW PHASE 3
     * ========================================== */

        public function showTransmettreForm(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('distribuer_courrier')) {
            return redirect()->route('courriers.show', $courrier)
                ->with('error', '💠 Accès non autorisé.');
        }

        if ($courrier->statut !== 'enregistre') {
            return redirect()->route('courriers.show', $courrier)
                ->with('error', '💠 Seuls les courriers enregistrés peuvent être transmis. Statut actuel : ' . $courrier->statut_label);
        }

        $departements = Departement::all();
        return view('courriers.transmettre', compact('courrier', 'departements'));
    }
    public function transmettre(Request $request, Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('distribuer_courrier')) {
            abort(403, 'Accès non autorisé.');
        }

        if ($courrier->statut !== 'enregistre') {
            return back()->with('error', '💠 Seuls les courriers enregistrés peuvent être transmis.');
        }

        $validated = $request->validate([
            'departement_id' => 'required|exists:departements,id',
            'note_transmission' => 'nullable|string|max:500',
        ]);

        $courrier->update([
            'departement_id' => $validated['departement_id'],
            'destinataire' => Departement::find($validated['departement_id'])->nom,
            'statut' => 'transmis',
            'contenu' => $validated['note_transmission'] 
                ? $courrier->contenu . "\n\n--- Note de transmission ---\n" . $validated['note_transmission'] 
                : $courrier->contenu,
        ]);

        $usersToNotify = User::where('departement_id', $validated['departement_id'])
                             ->where('is_active', true)
                             ->whereIn('role', ['secretaire', 'directeur', 'chef_service'])
                             ->get();
        
        foreach ($usersToNotify as $user) {
            $user->notify(new NouveauCourrierNotification($courrier));
        }

        AuditLog::logAction('transmettre', 'Transmission du courrier N° ' . $courrier->numero_enregistrement, $courrier);

        return back()->with('success', '📡 Courrier N° ' . $courrier->numero_enregistrement . ' transmis avec succès !');
    }

    /**
     * 🤝 ÉTAPE 5 : Prendre en charge
     */
    public function prendreEnCharge(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('receptionner_courrier')) {
            abort(403, 'Accès non autorisé.');
        }

        if ($courrier->departement_id !== Auth::user()->departement_id) {
            abort(403, '💠 Ce courrier n\'est pas destiné à votre département.');
        }

        if ($courrier->statut !== 'transmis') {
            return back()->with('error', '💠 Seuls les courriers transmis peuvent être pris en charge.');
        }

        // ✅ CORRECTION : On enlève 'heure_reception' pour éviter l'erreur SQL
        $courrier->update([
            'statut' => 'pris_en_charge',
            'date_reception' => now(), // Enregistre la date et l'heure actuelles
        ]);

        AuditLog::logAction('prendre_en_charge', 'Prise en charge du courrier N° ' . $courrier->numero_enregistrement, $courrier);

        return back()->with('success', '🤝 Courrier N° ' . $courrier->numero_enregistrement . ' pris en charge !');
    }
    public function classerSansReponse(Request $request, Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('traiter_courrier')) {
            abort(403, 'Accès non autorisé.');
        }

        if ($courrier->departement_id !== Auth::user()->departement_id) {
            abort(403, '💠 Ce courrier n\'est pas destiné à votre département.');
        }

        if (!in_array($courrier->statut, ['pris_en_charge', 'transmis'])) {
            return back()->with('error', '💠 Seuls les courriers pris en charge peuvent être classés.');
        }

        $validated = $request->validate([
            'note_cloture' => 'nullable|string|max:1000',
        ]);

        $courrier->update([
            'statut' => 'cloture',
            'contenu' => $validated['note_cloture'] 
                ? $courrier->contenu . "\n\n--- 🔒 Clôture sans réponse ---\n" . $validated['note_cloture'] 
                : $courrier->contenu,
        ]);

        AuditLog::logAction('classer_sans_reponse', 'Clôture sans réponse du courrier N° ' . $courrier->numero_enregistrement, $courrier);

        return back()->with('success', '🔒 Courrier N° ' . $courrier->numero_enregistrement . ' classé sans réponse !');
    }
        /**
     * 📥 ÉTAPE 1 : La secrétaire réceptionne le courrier interne et note la date/heure
     */
   
    /**
     * 📥 ÉTAPE 1 : La secrétaire réceptionne le courrier interne et note la date/heure
     */
    public function receptionnerInterne(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('receptionner_courrier')) {
            abort(403, 'Accès non autorisé.');
        }

        if ($courrier->departement_id !== Auth::user()->departement_id) {
            abort(403, '💠 Ce courrier n\'est pas destiné à votre département.');
        }

        // On accepte les statuts 'en_attente_reception' ou 'transmis'
        if (!in_array($courrier->statut, ['en_attente_reception', 'transmis'])) {
            return back()->with('error', '💠 Ce courrier ne peut pas être réceptionné pour le moment.');
        }

        // ✅ CORRECTION : On enlève 'heure_reception' pour éviter l'erreur SQL
        $courrier->update([
            'statut' => 'pris_en_charge',
            'date_reception' => now(), // Enregistre la date et l'heure actuelles
        ]);

        AuditLog::logAction('receptionner_interne', 'Réception du courrier interne N° ' . $courrier->numero_enregistrement, $courrier);

        return back()->with('success', '📥 Courrier interne réceptionné avec succès !');
    }

    
    
        /**
     * 📤 ÉTAPE 1B : La secrétaire envoie le courrier à son directeur (même département)
     */
    public function envoyerAuDirecteur(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('envoyer_courrier')) {
            abort(403, 'Accès non autorisé.');
        }

        if ($courrier->departement_id !== Auth::user()->departement_id) {
            abort(403, '💠 Ce courrier n\'est pas dans votre département.');
        }

        if ($courrier->statut !== 'pris_en_charge') {
            return back()->with('error', '💠 Seuls les courriers pris en charge peuvent être envoyés au directeur.');
        }

        // ✅ CORRECTION : Chercher via la relation 'roles' (Many-to-Many)
        $directeur = User::where('departement_id', Auth::user()->departement_id)
                         ->where('is_active', true)
                         ->whereHas('roles', function($query) {
                             $query->where('nom', 'directeur');
                         })
                         ->first();

        if (!$directeur) {
            return back()->with('error', '⚠️ Aucun directeur actif trouvé dans votre département. Veuillez vérifier que l\'utilisateur a bien le rôle "directeur" et le bon département.');
        }

        // ✅ Mise à jour : le courrier passe au directeur
        $courrier->update([
            'user_id' => $directeur->id,
            'statut' => 'en_attente_decision',
            'contenu' => $courrier->contenu . "\n\n--- 📤 Envoyé au directeur par " . Auth::user()->prenom . ' ' . Auth::user()->nom . ' ---',
        ]);

        // Notification au directeur
        $directeur->notify(new NouveauCourrierNotification($courrier));

        AuditLog::logAction('envoyer_directeur', 'Envoi au directeur du courrier N° ' . $courrier->numero_enregistrement, $courrier);

        return back()->with('success', '📤 Courrier envoyé au directeur ' . $directeur->prenom . ' ' . $directeur->nom . ' avec succès !');
    }
        public function showTransmettreInterneForm(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('distribuer_courrier') && !Auth::user()->hasPermission('traiter_courrier')) {
            abort(403, 'Accès non autorisé.');
        }
        
        $departements = Departement::all();
        return view('courriers.transmettre-interne', compact('courrier', 'departements'));
    }

    /**
     * 📤 ÉTAPE 2 : Transmission en mode "TRANSIT" (Vers directeur ou autre département)
     */
    public function transmettreInterne(Request $request, Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('distribuer_courrier') && !Auth::user()->hasPermission('traiter_courrier')) {
            abort(403, 'Accès non autorisé.');
        }

        if ($courrier->departement_id !== Auth::user()->departement_id) {
            abort(403, '💠 Vous ne pouvez transmettre que les courriers de votre département.');
        }

        $validated = $request->validate([
            'departement_id' => 'required|exists:departements,id',
            'note_transmission' => 'nullable|string|max:500',
        ]);

        $nouveauDepartement = Departement::find($validated['departement_id']);

        // ✅ MISE À JOUR AUTOMATIQUE EN MODE "TRANSIT"
        $courrier->update([
            'departement_id' => $validated['departement_id'],
            'destinataire' => $nouveauDepartement->nom,
            'sous_type' => 'transit', // ✅ Passe automatiquement en mode Transit
            'statut' => 'en_attente_reception', // ✅ Le destinataire devra le réceptionner à son tour
            'contenu' => $validated['note_transmission'] 
                ? $courrier->contenu . "\n\n--- 🔄 Transmission (Transit) ---\n" . $validated['note_transmission'] 
                : $courrier->contenu,
        ]);

        // Notification au nouveau département
        $usersToNotify = User::where('departement_id', $validated['departement_id'])
                             ->where('is_active', true)
                             ->whereIn('role', ['secretaire', 'directeur', 'chef_service'])
                             ->get();
        
        foreach ($usersToNotify as $user) {
            $user->notify(new NouveauCourrierNotification($courrier));
        }

        AuditLog::logAction('transit_interne', 'Transmission en transit du courrier N° ' . $courrier->numero_enregistrement . ' vers ' . $nouveauDepartement->nom, $courrier);

        return back()->with('success', '🚚 Courrier transmis en mode Transit au département ' . $nouveauDepartement->nom . ' avec succès !');
    }
        /**
     * ✅ DIRECTEUR : Valider/Traiter un courrier (après réception)
     */
    public function validerCourrier(Request $request, Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('traiter_courrier')) {
            abort(403, 'Accès non autorisé.');
        }

        if ($courrier->user_id !== Auth::id() && $courrier->statut !== 'en_attente_decision') {
            abort(403, 'Ce courrier ne vous est pas destiné.');
        }

        $validated = $request->validate([
            'decision' => 'required|in:valide,rejete,modifie',
            'commentaire_directeur' => 'nullable|string|max:1000',
        ]);

        $statutFinal = 'traite';
        if ($validated['decision'] === 'rejete') {
            $statutFinal = 'rejete';
        } elseif ($validated['decision'] === 'modifie') {
            $statutFinal = 'a_modifier';
        }

        $courrier->update([
            'statut' => $statutFinal,
            'contenu' => $courrier->contenu . "\n\n--- ✅ Décision du Directeur (" . Auth::user()->prenom . ' ' . Auth::user()->nom . ") ---\n" 
                . "Décision: " . ucfirst($validated['decision']) . "\n"
                . "Commentaire: " . ($validated['commentaire_directeur'] ?? 'Aucun commentaire') . "\n"
                . "Date: " . now()->format('d/m/Y H:i'),
        ]);

        // Notification à l'expéditeur initial (secrétaire)
        $userInitial = User::find($courrier->user_id);
        if ($userInitial && $userInitial->id !== Auth::id()) {
            $userInitial->notify(new NouveauCourrierNotification($courrier));
        }

        AuditLog::logAction('valider', 'Validation du courrier N° ' . $courrier->numero_enregistrement . ' par le directeur', $courrier);

        return back()->with('success', '✅ Courrier ' . $statutFinal . ' avec succès !');
    }

    /**
     * ✅ DIRECTEUR : Transmettre à un autre département (après validation)
     */
    public function transmettreApresValidation(Request $request, Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('traiter_courrier')) {
            abort(403, 'Accès non autorisé.');
        }

        if ($courrier->user_id !== Auth::id()) {
            abort(403, 'Ce courrier ne vous est pas destiné.');
        }

        $validated = $request->validate([
            'departement_id' => 'required|exists:departements,id',
            'note_transmission' => 'nullable|string|max:500',
        ]);

        $nouveauDepartement = Departement::find($validated['departement_id']);

        $courrier->update([
            'departement_id' => $validated['departement_id'],
            'destinataire' => $nouveauDepartement->nom,
            'sous_type' => 'transit',
            'statut' => 'en_attente_reception',
            'contenu' => $courrier->contenu . "\n\n--- 🔄 Transmission par le Directeur ---\n" 
                . "Vers: " . $nouveauDepartement->nom . "\n"
                . "Note: " . ($validated['note_transmission'] ?? 'Aucune note'),
        ]);

        // Notification au nouveau département
        $usersToNotify = User::where('departement_id', $validated['departement_id'])
                             ->where('is_active', true)
                             ->whereIn('role', ['secretaire', 'directeur', 'chef_service'])
                             ->get();
        
        foreach ($usersToNotify as $user) {
            $user->notify(new NouveauCourrierNotification($courrier));
        }

        AuditLog::logAction('transmis_directeur', 'Transmission par le directeur du courrier N° ' . $courrier->numero_enregistrement, $courrier);

        return back()->with('success', '🚚 Courrier transmis au département ' . $nouveauDepartement->nom . ' avec succès !');
    }

    /**
     * ✅ DIRECTEUR : Créer une réponse liée (si c'est un courrier Arrivée)
     */
    public function creerReponseLiee(Courrier $courrier)
    {
        if (!Auth::user()->hasPermission('traiter_courrier')) {
            abort(403, 'Accès non autorisé.');
        }

        if ($courrier->type !== 'arrivee') {
            return back()->with('error', 'Seuls les courriers Arrivée peuvent avoir une réponse liée.');
        }

        return redirect()->route('courriers.create', [
            'type' => 'depart',
            'lie_a' => $courrier->id
        ]);
    }
}