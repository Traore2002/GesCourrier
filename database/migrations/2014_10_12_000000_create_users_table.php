<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique(); // Ajout du matricule unique
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Champs spécifiques à SOSUCO
            $table->string('role')->nullable(); // 'admin', 'chef', 'secretaire', etc.
            $table->foreignId('departement_id')->nullable()->constrained('departements')->nullOnDelete(); // Lien vers la table departements
            $table->boolean('is_active')->default(true); // Compte actif ou non
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};