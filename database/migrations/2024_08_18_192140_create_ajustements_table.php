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
        Schema::create('ajustements', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->foreignId('achat_id') 
            ->nullable()
                ->constrained('achats')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('mouvement')->unique()->nullable(); //entree ? sortie
            $table->string('stock_actuel')->nullable(); //
            $table->string('stock_ajustement')->nullable(); //

            $table->foreignId('user_id')
            ->nullable()
                ->constrained('users')
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
        Schema::dropIfExists('ajustements');
    }
};
