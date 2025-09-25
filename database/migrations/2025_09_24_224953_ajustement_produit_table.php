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
        Schema::create('ajustement_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ajustement_id')
                ->nullable()
                ->constrained('ajustements')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->onUpdate('cascade')
                ->onDelete('cascade');



            $table->integer('stock_disponible')->nullable();
            $table->enum('type_ajustement', ['ajouter', 'reduire'])->nullable();
            $table->integer('stock_ajuste')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustement_produit');
    }
};
