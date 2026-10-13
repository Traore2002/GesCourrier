<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('courriers', function (Blueprint $table) {
            $table->string('sous_type')->nullable()->after('type');
        });
    }

    public function down()
    {
        Schema::table('courriers', function (Blueprint $table) {
            $table->dropColumn('sous_type');
        });
    }
};