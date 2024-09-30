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
        Schema::create('inventaire_produit', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventaire_id')
                ->nullable()
                ->constrained('inventaires')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // $table->float('stock_global')->nullable(); // stock net
            $table->float('stock_systeme')->nullable(); //stock apres vente
            $table->float('stock_physique')->nullable(); // stock disponible
            $table->float('ecart')->nullable();
            $table->enum('etat', ['en rupture', 'en stock', 'stock critique', 'stock manquant', 'Stock excédentaire'])->nullable(); //en rupture , en stock , endommagé, Stock critique 
            $table->string('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaire_produit');
    }
};
