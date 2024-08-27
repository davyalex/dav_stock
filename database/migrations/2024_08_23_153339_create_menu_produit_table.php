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
        Schema::create('menu_produit', function (Blueprint $table) {
            $table->id();

            //foreign table
            $table->foreignId('menu_id')
                ->nullable()
                ->constrained('menus')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

            //foreign table
            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

                $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_produit');
    }
};
