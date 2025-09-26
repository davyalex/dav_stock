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
        Schema::create('intrant_sortie', function (Blueprint $table) {
            //
            $table->id();

            $table->foreignId('sortie_id')
                ->nullable()
                ->constrained('sorties')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('intrant_id')
                ->nullable()
                ->constrained('intrants')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->integer('stock_disponible')->nullable();
            $table->integer('stock_sortie')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('intrant_sortie', function (Blueprint $table) {
            //
        });
    }
};
