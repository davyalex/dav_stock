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
        Schema::create('produit_entree', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entree_id')
                ->nullable()
                ->constrained('entrees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('stock_disponible')->nullable();
            $table->integer('stock_entree')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_entree');
    }
};
