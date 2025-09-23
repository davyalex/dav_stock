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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->dateTime('date_vente')->nullable();

            $table->double('montant_recu')->nullable();
            $table->double('montant_rendu')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->double('montant_avant_remise')->nullable();
            $table->string('type_remise')->nullable();
            $table->double('valeur_remise')->nullable();
            $table->double('montant_remise')->nullable();
            $table->double('montant_total')->nullable();

            $table->foreignId('client_id')  // client qui passe la vente
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->foreignId('caisse_id')
                ->nullable()
                ->constrained('caisses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('user_id')  // utilisateur qui a fait la vente
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');


                
      
            $table->foreignId('mode_paiement_id')  // utilisateur qui a fait la vente
                ->nullable()
                ->constrained('mode_paiements')
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
        Schema::dropIfExists('ventes');
    }
};
