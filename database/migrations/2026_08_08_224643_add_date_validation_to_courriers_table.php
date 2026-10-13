<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courriers', function (Blueprint $table) {
            // On ajoute la date de validation, uniquement utile pour les courriers internes
            $table->date('date_validation')->nullable()->after('date_envoi');
        });
    }

    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            $table->dropColumn('date_validation');
        });
    }
};