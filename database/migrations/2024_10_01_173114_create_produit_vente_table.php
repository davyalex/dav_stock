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
        Schema::create('produit_vente`', function (Blueprint $table) {
            $table->id();
            $table->integer('quantite')->nullable(); // quantite du produit
            $table->double('prix_unitaire')->nullable(); //prix  unitaire
            $table->double('total')->nullable(); // total quantite * prix unitaire


            $table->foreignId('vente_id')
                ->nullable()
                ->constrained('ventes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_vente');
    }
};
