<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // ✅ 1. Champs pour le Courrier Arrivée (Étapes 2 et 3)
            $table->integer('nombre_pieces_jointes')->default(1)->after('fichier_scanne');
            $table->boolean('necessite_reponse')->default(false)->after('nombre_pieces_jointes');
            $table->string('priorite', 20)->default('normal')->after('necessite_reponse'); // 'normal' ou 'urgent'

            // ✅ 2. Champs pour le Lien entre courriers (Étape 7)
            // On utilise unsignedBigInteger pour éviter les erreurs de référence circulaire
            $table->unsignedBigInteger('courrier_arrive_lie_id')->nullable()->after('priorite');

            // ✅ 3. Champs pour l'Envoi et la Clôture (Étapes 10 et 11)
            $table->date('date_envoi_effectif')->nullable()->after('courrier_arrive_lie_id');
            $table->string('numero_suivi', 100)->nullable()->after('date_envoi_effectif');
            $table->date('accuse_reception_date')->nullable()->after('numero_suivi');
        });
    }

    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            $table->dropColumn([
                'nombre_pieces_jointes', 
                'necessite_reponse', 
                'priorite', 
                'courrier_arrive_lie_id',
                'date_envoi_effectif', 
                'numero_suivi', 
                'accuse_reception_date'
            ]);
        });
    }
};