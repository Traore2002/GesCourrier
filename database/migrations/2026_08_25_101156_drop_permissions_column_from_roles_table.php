<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // On vérifie si la colonne existe avant de la supprimer (pour éviter les erreurs)
            if (Schema::hasColumn('roles', 'permissions')) {
                $table->dropColumn('permissions');
            }
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Au cas où on voudrait revenir en arrière
            $table->json('permissions')->nullable();
        });
    }
};