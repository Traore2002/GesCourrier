<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // Numéro unique d'enregistrement (ex: ARR-2026-0001)
            $table->string('numero_enregistrement')->unique()->nullable()->after('id');
            // Chemin du fichier scanné
            $table->string('fichier_scanne')->nullable()->after('contenu');
        });
    }

    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            $table->dropColumn(['numero_enregistrement', 'fichier_scanne']);
        });
    }
};