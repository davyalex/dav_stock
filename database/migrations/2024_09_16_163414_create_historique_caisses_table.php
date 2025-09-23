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
        Schema::create('historique_caisses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caisse_id')
            ->nullable()
            ->constrained('caisses')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->dateTime('date_ouverture')->nullable();
            $table->dateTime('date_fermeture')->nullable();
            
            $table->date('session_date_vente')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_caisses');
    }
};
