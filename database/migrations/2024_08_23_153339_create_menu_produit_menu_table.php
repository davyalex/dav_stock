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
        Schema::create('menu_produit_menu', function (Blueprint $table) {
            $table->id();
            //foreign table
            $table->foreignId('categorie_id')
                ->nullable()
                ->constrained('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

            //foreign table
            $table->foreignId('menu_id')
                ->nullable()
                ->constrained('menus')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

            //foreign table
            $table->foreignId('produit_menus_id')
                ->nullable()
                ->constrained('produit_menus')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_produit_menu');
    }
};
