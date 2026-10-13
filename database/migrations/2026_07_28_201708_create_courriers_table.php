<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courriers', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'arrivee', 'depart', 'interne'
            $table->string('objet');
            $table->string('reference')->nullable();
            $table->string('expediteur');
            $table->string('destinataire');
            $table->date('date_reception')->nullable();
            $table->date('date_envoi')->nullable();
            $table->string('statut')->default('en_cours'); // 'en_cours', 'traite', 'archive'
            $table->text('contenu')->nullable();
            
            // Liens vers les autres tables
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('departement_id')->nullable()->constrained('departements')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courriers');
    }
};