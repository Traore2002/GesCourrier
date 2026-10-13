<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // ✅ On vérifie si la colonne existe avant de l'ajouter
            if (!Schema::hasColumn('courriers', 'date_reception')) {
                $table->timestamp('date_reception')->nullable()->after('statut');
            }
            if (!Schema::hasColumn('courriers', 'date_envoi_direction')) {
                $table->timestamp('date_envoi_direction')->nullable()->after('date_reception');
            }
            if (!Schema::hasColumn('courriers', 'date_traitement')) {
                $table->timestamp('date_traitement')->nullable()->after('date_envoi_direction');
            }
            if (!Schema::hasColumn('courriers', 'user_createur_id')) {
                $table->unsignedBigInteger('user_createur_id')->nullable()->after('user_id');
            }
        });

        // Mettre à jour les anciens statuts (cette partie est sans risque)
        DB::table('courriers')
            ->whereIn('statut', ['brouillon', 'en_cours'])
            ->update(['statut' => 'en_attente_reception']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // ✅ On vérifie si la colonne existe avant de la supprimer
            if (Schema::hasColumn('courriers', 'date_reception')) {
                $table->dropColumn('date_reception');
            }
            if (Schema::hasColumn('courriers', 'date_envoi_direction')) {
                $table->dropColumn('date_envoi_direction');
            }
            if (Schema::hasColumn('courriers', 'date_traitement')) {
                $table->dropColumn('date_traitement');
            }
            if (Schema::hasColumn('courriers', 'user_createur_id')) {
                $table->dropColumn('user_createur_id');
            }
        });

        DB::table('courriers')
            ->where('statut', 'en_attente_reception')
            ->update(['statut' => 'en_cours']);
    }
};