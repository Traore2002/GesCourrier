<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeCourrier;

class TypeCourrierSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['nom' => 'Arrivée', 'prefixe' => 'ARR', 'description' => 'Courrier reçu de l\'extérieur'],
            ['nom' => 'Départ', 'prefixe' => 'DEP', 'description' => 'Courrier envoyé à l\'extérieur'],
            ['nom' => 'Interne', 'prefixe' => 'INT', 'description' => 'Courrier entre départements'],
        ];

        foreach ($types as $type) {
            TypeCourrier::create($type);
        }
    }
}