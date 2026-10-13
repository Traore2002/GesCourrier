<?php

namespace App\Http\Controllers;

use App\Models\Courrier;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Requête de base
        $query = Courrier::with(['departement', 'categorie', 'user']);
        
        // ✅ Filtres de recherche textuelle
        if ($request->filled('objet')) {
            $query->where('objet', 'LIKE', '%' . $request->objet . '%');
        }
        
        if ($request->filled('numero_enregistrement')) {
            $query->where('numero_enregistrement', 'LIKE', '%' . $request->numero_enregistrement . '%');
        }

        // ✅ NOUVEAU : Filtre par Référence
        if ($request->filled('reference')) {
            $query->where('reference', 'LIKE', '%' . $request->reference . '%');
        }
        
        if ($request->filled('expediteur')) {
            $query->where('expediteur', 'LIKE', '%' . $request->expediteur . '%');
        }
        
        if ($request->filled('destinataire')) {
            $query->where('destinataire', 'LIKE', '%' . $request->destinataire . '%');
        }
        
        // ✅ Filtres par sélection
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }
        
        // ✅ Filtres de dates
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        
        // ✅ Filtrer selon le rôle de l'utilisateur (Sécurité des données)
        if ($user->role === 'administrateur' || $user->isAdmin()) {
            // Voit tout
        } elseif ($user->role === 'standardiste') {
            $query->whereNull('departement_id');
        } elseif (in_array($user->role, ['secretaire', 'directeur']) && $user->departement_id) {
            $query->where('departement_id', $user->departement_id);
        } else {
            $query->where('id', 0); // Sécurité fallback
        }
        
        $courriers = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = Categorie::all();
        
        return view('search.index', compact('courriers', 'categories'));
    }
}