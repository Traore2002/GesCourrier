<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Afficher la liste des rôles
     */
    public function index()
    {
        // ✅ CORRECTION : Suppression de orderBy('groupe') car la colonne n'existe pas
        $roles = Role::with('permissions')->orderBy('nom')->get();
        $permissions = Permission::orderBy('label')->get();
        
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Afficher le formulaire de création d'un rôle
     */
    public function create()
    {
        // ✅ CORRECTION : Suppression de orderBy('groupe')
        $permissions = Permission::orderBy('label')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Enregistrer un nouveau rôle
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:roles,nom',
            'description' => 'nullable|string',
            'actif' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'actif' => $request->has('actif'), // Correction pour garantir un booléen
        ]);

        // Synchroniser les permissions
        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle créé avec succès !');
    }

    /**
     * Afficher le formulaire de modification d'un rôle
     */
    public function edit(Role $role)
    {
        // ✅ CORRECTION : Suppression de la première méthode edit en double.
        // On garde celle-ci qui est la bonne.
        
        // Charge les permissions actuellement liées à ce rôle
        $role->load('permissions');
        // Récupère TOUTES les permissions disponibles dans la BDD
        $allPermissions = Permission::orderBy('label')->get();
        
        return view('admin.roles.edit', compact('role', 'allPermissions'));
    }

    /**
     * Mettre à jour un rôle
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'actif' => 'boolean',
            'permissions' => 'nullable|array', 
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'nom' => $validated['nom'],
            'description' => $validated['description'] ?? null,
            'actif' => $request->has('actif'),
        ]);

        // ✅ C'est cette ligne qui coche/décoche automatiquement les permissions !
        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle et permissions mis à jour avec succès !');
    }

    /**
     * Supprimer un rôle
     */
    public function destroy(Role $role)
    {
        // Vérifier si le rôle est utilisé par des utilisateurs
        if ($role->users()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer ce rôle : il est attribué à des utilisateurs.');
        }

        $role->delete();
        
        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle supprimé avec succès !');
    }
}