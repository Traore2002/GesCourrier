<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workflows', function (Blueprint $table) {
            // Si la colonne 'nom' existe, on la renomme en 'name'
            if (Schema::hasColumn('workflows', 'nom')) {
                $table->renameColumn('nom', 'name');
            }
            // Sinon, on ajoute la colonne name
            else if (!Schema::hasColumn('workflows', 'name')) {
                $table->string('name')->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('workflows', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};