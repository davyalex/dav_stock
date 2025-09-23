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
        Schema::create('menu_plat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_id')
                ->nullable()
                ->constrained('menus')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

            //foreign table
            $table->foreignId('plat_id')
                ->nullable()
                ->constrained('plats')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

            $table->foreignId('categorie_menu_id')
                ->nullable()
                ->constrained('categorie_menus')
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
        Schema::dropIfExists('menu_plat');
    }
};
