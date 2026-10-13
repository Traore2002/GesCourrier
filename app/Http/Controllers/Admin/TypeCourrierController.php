<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeCourrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeCourrierController extends Controller
{
    public function __construct()
    {
        // Seul l'administrateur peut gérer les types de courriers
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'administrateur') {
                abort(403, 'Accès non autorisé.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $types = TypeCourrier::orderBy('created_at', 'desc')->get();
        return view('admin.type-courriers.index', compact('types'));
    }

    // ✅ NOUVEAU : Afficher le formulaire de création
   public function create()
{
    // Récupérer tous les types existants pour les afficher
    $existingTypes = \App\Models\TypeCourrier::all();
    return view('admin.type-courriers.create', compact('existingTypes'));
}

    // ✅ NOUVEAU : Enregistrer le nouveau type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:type_courriers,nom',
            'prefixe' => 'required|string|max:10|unique:type_courriers,prefixe', // ✅ CORRIGÉ : 'prefixe' au lieu de 'prefix'
            'description' => 'nullable|string',
            'actif' => 'boolean',
        ]);

        TypeCourrier::create($validated);

        return redirect()->route('admin.type-courriers.index')
            ->with('success', 'Type de courrier créé avec succès !');
    }
    public function destroy(TypeCourrier $typeCourrier)
    {
        // 1. Vérifier si ce type est déjà utilisé dans au moins un courrier
        // (On suppose que la colonne 'type' de la table 'courriers' contient le 'nom' du type)
        $estUtilise = \App\Models\Courrier::where('type', $typeCourrier->nom)->exists();

        if ($estUtilise) {
            // 2. Si OUI : On ne supprime pas, on désactive (actif = false)
            $typeCourrier->update(['actif' => false]);
            
            return redirect()->route('admin.type-courriers.index')
                ->with('warning', "Le type '{$typeCourrier->nom}' ne peut pas être supprimé car il est déjà utilisé dans l'historique des courriers. Il a été **désactivé** et n'apparaîtra plus dans les nouveaux formulaires.");
        }

        // 3. Si NON : La voie est libre, on peut le supprimer définitivement
        $typeCourrier->delete();
        
        return redirect()->route('admin.type-courriers.index')
            ->with('success', 'Type de courrier supprimé avec succès.');
    }
}