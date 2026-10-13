<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            // Ajoute la colonne categorie_id après departement_id
            $table->foreignId('categorie_id')->nullable()->after('departement_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // Supprime la clé étrangère puis la colonne en cas d'annulation
            $table->dropForeign(['categorie_id']);
            $table->dropColumn('categorie_id');
        });
    }
};