<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // ex: "creer_courrier", "supprimer_utilisateur"
            $table->string('label'); // ex: "Créer un courrier", "Supprimer un utilisateur"
            $table->string('groupe')->nullable(); // ex: "courriers", "utilisateurs", "admin"
            $table->timestamps();
        });

        // Table pivot pour lier permissions et rôles
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
    }
};