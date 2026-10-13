<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['nom' => 'administrateur', 'description' => 'Accès complet à toutes les fonctionnalités et à la configuration'],
            ['nom' => 'standardiste', 'description' => 'Réception, enregistrement et distribution des courriers'],
            ['nom' => 'secretaire', 'description' => 'Traitement et suivi des courriers au sein d\'un département'],
            ['nom' => 'directeur', 'description' => 'Validation et supervision des courriers du département'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}