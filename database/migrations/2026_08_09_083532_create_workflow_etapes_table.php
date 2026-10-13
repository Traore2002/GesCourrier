<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workflow_etapes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained('workflows')->onDelete('cascade');
            $table->integer('ordre'); // 1, 2, 3... pour définir la séquence
            $table->string('role_nom'); // Le nom du rôle responsable (ex: 'standardiste'), lié à la table roles
            $table->string('action_requise')->default('traiter'); // ex: 'distribuer', 'traiter', 'valider'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflow_etapes');
    }
};