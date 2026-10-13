<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // Champs Arrivée
            $table->date('date_arrivee')->nullable()->after('reference');
            $table->time('heure_arrivee')->nullable()->after('date_arrivee');
            $table->date('date_courrier_expediteur')->nullable()->after('heure_arrivee');
            $table->string('type_document', 50)->nullable()->after('date_courrier_expediteur');
            
            // Champs Départ
            $table->string('destinataire_nom_fonction', 255)->nullable()->after('type_document');
            $table->string('destinataire_structure', 255)->nullable()->after('destinataire_nom_fonction');
            $table->string('destinataire_ville_adresse', 255)->nullable()->after('destinataire_structure');
            $table->string('signataire_nom', 255)->nullable()->after('destinataire_ville_adresse');
            $table->string('signataire_fonction', 255)->nullable()->after('signataire_nom');
            $table->string('mode_expedition', 50)->nullable()->after('signataire_fonction');
            $table->boolean('transmis_standardiste')->default(false)->after('mode_expedition');
        });
    }

    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            $table->dropColumn([
                'date_arrivee', 'heure_arrivee', 'date_courrier_expediteur', 'type_document',
                'destinataire_nom_fonction', 'destinataire_structure', 'destinataire_ville_adresse',
                'signataire_nom', 'signataire_fonction', 'mode_expedition', 'transmis_standardiste'
            ]);
        });
    }
};