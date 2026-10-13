<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            // On lie le workflow à un type de courrier spécifique
            $table->foreignId('type_courrier_id')->constrained('type_courriers')->onDelete('cascade');
            $table->string('nom'); // ex: "Circuit standard Arrivée"
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workflows');
    }
};