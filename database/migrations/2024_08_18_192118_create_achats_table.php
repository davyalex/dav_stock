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
            $table->string('statut')->nullable(); //actif ? desactive

            $table->foreignId('type_produit_id')  //type produit  = boissons ? ingredients
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

            $table->integer('quantite_format')->nullable(); //quantité par format


            $table->foreignId('unite_id')
                ->nullable()
                ->constrained('unites')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // $table->integer('quantite_unite_unitaire')->nullable(); //quantité unitaire par unité
            // $table->integer('quantite_unite_total')->nullable(); //quantité total par unité --qté stockable
            $table->integer('quantite_stockable')->nullable(); //
            // $table->integer('quantite_sortie')->nullable(); //qté stockable total
            $table->double('prix_achat_unitaire')->nullable(); //prix d'achat unitaire
            $table->double('prix_achat_total')->nullable(); //prix d'achat total


            //autre chams de type bar
            // $table->string('ugs_poids')->nullable(); // unite de mesure
            // $table->string('ugs_valeur')->nullable(); // valeur
            // $table->string('ugs_ballon')->nullable(); // nombre de par rapport à la mesure
            // $table->string('ugs_tournee')->nullable(); // 
            $table->double('prix_vente_unitaire')->nullable(); //prix de vente par unite
            $table->double('prix_vente_total')->nullable(); //prix de vente total

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
        Schema::dropIfExists('achats');
    }
};
