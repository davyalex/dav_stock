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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('nom')->unique()->nullable(); // libelle
            $table->string('slug')->nullable();
            $table->double('prix')->nullable();
            $table->integer('stock')->default(0); //quantité en stock
            $table->longText('description')->nullable();
            $table->enum('visible', ['oui', 'non'])->default('oui');
        
            //foreign table
            $table->foreignId('categorie_id')
            ->nullable()
            ->constrained('categories')
            ->onUpdate('cascade')
            ->onDelete('cascade ');

            $table->foreignId('type_id') // type de produit
            ->nullable()
            ->constrained('categories')
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
        Schema::dropIfExists('produits');
    }
};
