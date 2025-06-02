<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inventaires', function (Blueprint $table) {
            //
            $table->unsignedTinyInteger('mois_concerne')->after('date_inventaire');
            $table->unsignedSmallInteger('annee_concerne')->after('mois_concerne');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventaires', function (Blueprint $table) {
            //
            $table->dropColumn(['mois_concerne', 'annee_concerne']);
        });
    }
};
