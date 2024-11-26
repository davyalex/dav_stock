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
        Schema::create('plat_garniture', function (Blueprint $table) {
            $table->id();

            $table->foreignId('plat_id')
                ->nullable()
                ->constrained('plats')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->foreignId('garniture_id')
                ->nullable()
                ->constrained('plats') // 
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('menu_id')
                ->nullable()
                ->constrained('menus')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plat_garniture');
    }
};
