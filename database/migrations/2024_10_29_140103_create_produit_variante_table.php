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
        Schema::create('produit_variante', function (Blueprint $table) {
            $table->id();
            $table->double('quantite')->nullable();
            $table->double('prix')->nullable();
            $table->double('total')->nullable();


            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

            $table->foreignId('variante_id')
                ->nullable()
                ->constrained('variantes')
                ->onUpdate('cascade')
                ->onDelete('cascade ');
            $table->double('quantite_stocke')->nullable(); // quantite stocké
            $table->double('quantite_disponible')->nullable(); // quantite disponible
            $table->double('quantite_vendu')->nullable(); // quantite utilise
            $table->double('bouteille_vendu')->nullable(); // bouteille utilise




            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_variante');
    }
};
