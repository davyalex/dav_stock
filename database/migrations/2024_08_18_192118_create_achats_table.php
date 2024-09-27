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
        Schema::create('achats', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('numero_facture')->nullable();
            $table->date('date_achat')->nullable();

            $table->enum('statut' , ['active' , 'desactive'])->default('active')->nullable(); //actif ? desactive

            $table->foreignId('type_produit_id')  //type produit  = bar  ? restaurant
                ->nullable()
                ->constrained('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('produit_id')
                ->nullable()
                ->constrained('produits')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('fournisseur_id')
                ->nullable()
                ->constrained('fournisseurs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('format_id')
                ->nullable()
                ->constrained('formats')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->float('quantite_format')->nullable(); //quantité de format
            $table->float('quantite_in_format')->nullable(); //quantité dans un format

            $table->float('quantite_stocke')->nullable(); // quantite total des piece dans les formats
            $table->double('prix_unitaire_format')->nullable(); //prix unitaire d'un format
            $table->double('prix_total_format')->nullable(); //prix total d'un format
            $table->double('prix_achat_unitaire')->nullable(); //prix d'achat unitaire d'une piece dans un format (calcule automatique)
            $table->double('prix_vente_unitaire')->nullable(); //prix de vente par unite



            $table->foreignId('unite_id')  // unite de sortie(vente)
                ->nullable()
                ->constrained('unites')
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

                $table->foreignId('facture_id')
                ->nullable()
                ->constrained('factures')
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
        Schema::dropIfExists('achats');
    }
};
