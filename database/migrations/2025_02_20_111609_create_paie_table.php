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
        Schema::create('paies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->double('montant')->nullable();
            $table->enum('statut', ['en attente', 'paye'])->nullable();
            $table->date('date_paiement')->nullable();
            $table->integer('mois'); // Stocke le mois (1 à 12)
            $table->integer('annee'); // Stocke l'année (ex: 2024)
            $table->foreignId('type_paie')->nullable()->constrained('libelle_depenses')->onDelete('cascade')->onUpdate('cascade');
            // foreignId employeId
           
           
            $table->foreignId('employe_id')->nullable()->constrained('employes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paies');
    }
};
