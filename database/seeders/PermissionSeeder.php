<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Permissions Courriers
            ['nom' => 'creer_courrier', 'label' => 'Créer un courrier', 'groupe' => 'courriers'],
            ['nom' => 'modifier_courrier', 'label' => 'Modifier un courrier', 'groupe' => 'courriers'],
            ['nom' => 'supprimer_courrier', 'label' => 'Supprimer un courrier', 'groupe' => 'courriers'],
            ['nom' => 'voir_courrier', 'label' => 'Voir un courrier', 'groupe' => 'courriers'],
            ['nom' => 'distribuer_courrier', 'label' => 'Distribuer un courrier', 'groupe' => 'courriers'],
            ['nom' => 'archiver_courrier', 'label' => 'Archiver un courrier', 'groupe' => 'courriers'],
            
            // Permissions Utilisateurs
            ['nom' => 'creer_utilisateur', 'label' => 'Créer un utilisateur', 'groupe' => 'utilisateurs'],
            ['nom' => 'modifier_utilisateur', 'label' => 'Modifier un utilisateur', 'groupe' => 'utilisateurs'],
            ['nom' => 'supprimer_utilisateur', 'label' => 'Supprimer un utilisateur', 'groupe' => 'utilisateurs'],
            ['nom' => 'voir_utilisateur', 'label' => 'Voir un utilisateur', 'groupe' => 'utilisateurs'],
            
            // Permissions Admin
            ['nom' => 'gerer_roles', 'label' => 'Gérer les rôles', 'groupe' => 'admin'],
            ['nom' => 'gerer_permissions', 'label' => 'Gérer les permissions', 'groupe' => 'admin'],
            ['nom' => 'voir_audit', 'label' => 'Voir le journal d\'audit', 'groupe' => 'admin'],
            ['nom' => 'gerer_types', 'label' => 'Gérer les types de courriers', 'groupe' => 'admin'],
            ['nom' => 'gerer_workflows', 'label' => 'Gérer les workflows', 'groupe' => 'admin'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}