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
            $table->string('nom')->nullable(); // libelle
            $table->string('slug')->nullable();
            $table->double('prix')->nullable();
            $table->double('stock_initial')->default(0); // stock net
            $table->double('stock')->default(0); //quantité en stock
            $table->double('stock_alerte')->default(0); //
            $table->longText('description')->nullable();
            $table->enum('statut', ['active', 'desactive'])->default('active');
            $table->double('stock_dernier_inventaire')->default(0); //quantité en stock
            
            

            //foreign table
            $table->foreignId('categorie_id')
                ->nullable()
                ->constrained('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade ');

            $table->foreignId('type_id') // type de produit  : boissons , ingredients, plats
                ->nullable()
                ->constrained('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->foreignId('magasin_id')
                ->nullable()
                ->constrained('magasins')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->double('valeur_unite')->nullable(); //quantite unite mesure
            $table->foreignId('unite_id')
                ->nullable()
                ->constrained('unites')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->double('valeur_format')->nullable(); //quantite du format
            $table->foreignId('format_id') // format du produit
                ->nullable()
                ->constrained('formats')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('unite_sortie_id')  //unite du stock sortie
                ->nullable()
                ->constrained('unites')
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
