<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courriers', function (Blueprint $table) {
            $table->date('date_transmission')->nullable()->after('type_document');
            $table->string('priorite_envoi', 20)->default('normal')->after('date_transmission');
            $table->string('mode_envoi_effectif', 50)->nullable()->after('priorite_envoi');
            $table->date('date_envoi_physique')->nullable()->after('mode_envoi_effectif');
            $table->boolean('ar_recu')->default(false)->after('numero_suivi');
            $table->date('date_reception_ar')->nullable()->after('ar_recu');
            $table->string('fichier_ar')->nullable()->after('date_reception_ar');
        });
    }

    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            $table->dropColumn(['date_transmission', 'priorite_envoi', 'mode_envoi_effectif', 'date_envoi_physique', 'ar_recu', 'date_reception_ar', 'fichier_ar']);
        });
    }
};