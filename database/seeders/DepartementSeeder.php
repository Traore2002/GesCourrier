<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departement;

class DepartementSeeder extends Seeder
{
    public function run()
    {
        $departements = [
            ['nom' => 'Culture', 'code' => 'CUL'],
            ['nom' => 'Commercial', 'code' => 'COM'],
            ['nom' => 'Communication', 'code' => 'COMM'],
            ['nom' => 'Direction Générale', 'code' => 'DG'],
            ['nom' => 'Direction Industrie', 'code' => 'DI'],
            ['nom' => 'Département Qualité', 'code' => 'DQ'],
            ['nom' => 'Ressources Humaines', 'code' => 'RH'],
            ['nom' => 'Mécanisation', 'code' => 'MEC'],
            ['nom' => 'Achats et Stocks', 'code' => 'AS'],
            ['nom' => 'Distillerie', 'code' => 'DIST'],
            ['nom' => 'Direction Exploitation', 'code' => 'DE'],
        ];

        foreach ($departements as $departement) {
            Departement::create($departement);
        }

        $this->command->info('11 départements insérés avec succès !');
    }
}