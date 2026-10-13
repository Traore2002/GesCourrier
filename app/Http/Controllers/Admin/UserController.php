<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Departement;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 1. Affiche la liste des utilisateurs
     */
    public function index()
    {
        if (Auth::user()->role !== 'administrateur') {
            abort(403, 'Accès non autorisé. Réservé aux administrateurs.');
        }

        $users = User::with(['departement', 'roles'])->orderBy('created_at', 'desc')->get();
        $departements = Departement::all();
        $roles = Role::where('actif', true)->get();

        return view('admin.users.index', compact('users', 'departements', 'roles'));
    }

    /**
     * 2. Afficher le formulaire de création d'un utilisateur
     */
    public function create()
    {
        $departements = Departement::all();
        $roles = Role::where('actif', true)->get();
        
        return view('admin.users.create', compact('departements', 'roles'));
    }

    /**
     * 3. Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:50|unique:users,matricule',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed', 
            
            'role_ids' => 'required|array|min:1',
            'role_ids.*' => 'exists:roles,id',
            
            'departement_id' => 'nullable|exists:departements,id',
            'is_active' => 'boolean',
        ]);

        $user = User::create([
            'matricule' => $validated['matricule'],
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'departement_id' => !empty($validated['departement_id']) ? $validated['departement_id'] : null,
            'is_active' => $request->has('is_active'),
        ]);

        $user->roles()->sync($validated['role_ids']);

        return redirect()->route('admin.users.index')
            ->with('success', 'L\'utilisateur a été créé avec succès !');
    }

    /**
     * 4. Afficher le formulaire de modification
     */
    public function edit(User $user)
    {
        $user->load('roles');
        $departements = Departement::all();
        $roles = Role::where('actif', true)->get();

        return view('admin.users.edit', compact('user', 'departements', 'roles'));
    }

    /**
     * 5. Mettre à jour l'utilisateur
     */
       /**
     * 5. Mettre à jour l'utilisateur (Version Blindée)
     */
    public function update(Request $request, User $user)
    {
        // 1. On récupère les rôles ACTUELS de l'utilisateur par défaut
        $defaultRoles = $user->roles->pluck('id')->toArray();
        
        // 2. On regarde ce que le formulaire envoie. 
        // Si rien n'est envoyé (aucune case cochée), on garde les rôles par défaut.
        $roleIds = $request->has('role_ids') ? $request->input('role_ids') : $defaultRoles;
        
        // Sécurité : si le tableau est vide [], on force les rôles par défaut
        if (empty($roleIds)) {
            $roleIds = $defaultRoles;
        }

        // 3. Validation : On retire 'role_ids' des règles obligatoires.
        // On valide seulement le CONTENU du tableau s'il existe (que ce soient des IDs valides)
        $validated = $request->validate([
            'matricule' => 'required|string|max:50|unique:users,matricule,' . $user->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'departement_id' => 'nullable|exists:departements,id',
            'is_active' => 'boolean',
            
            // ✅ On valide uniquement que les éléments du tableau sont des IDs de rôles existants
            'role_ids.*' => 'exists:roles,id', 
        ]);

        // Préparation des données
        $updateData = [
            'matricule' => $validated['matricule'],
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'departement_id' => !empty($validated['departement_id']) ? $validated['departement_id'] : null,
            'is_active' => $request->has('is_active'),
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Mise à jour des infos de base
        $user->update($updateData);

        // ✅ Synchronisation avec les rôles déterminés (pas ceux de la validation)
        $user->roles()->sync($roleIds);

        return redirect()->route('admin.users.index')
            ->with('success', 'L\'utilisateur a été mis à jour avec succès !');
    }
    /**
     * 6. Supprime un utilisateur
     */
    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'administrateur') {
            abort(403, 'Accès non autorisé.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'L\'utilisateur a été supprimé avec succès !');
    }
}