<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table des permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique(); // ex: 'receptionner_courrier'
            $table->string('label');         // ex: 'Réceptionner un courrier'
            $table->timestamps();
        });

        // Table de liaison Rôle <-> Permission
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->unique(['role_id', 'permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
    }
};