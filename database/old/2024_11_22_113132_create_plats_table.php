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
        Schema::create('plats', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('nom')->nullable(); // libelle
            $table->string('slug')->nullable();
            $table->double('prix')->nullable();
            $table->longText('description')->nullable();
            $table->enum('statut', ['active', 'desactive'])->default('active');

            //foreign table
            $table->foreignId('categorie_menu_id')
                ->nullable()
                ->constrained('categorie_menus')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plats');
    }
};
