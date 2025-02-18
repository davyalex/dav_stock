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
            $table->double('montant')->nullable();
            $table->enum('type', ['avance', 'salaire', 'prime', 'indemnité'])->nullable();
            $table->enum('statut', ['en attente', 'paye'])->nullable();
            $table->date('date_paiement')->nullable();
            // foreignId employeId
            $table->foreignId('employe_id')->constrained('employes')->onDelete('cascade')->onUpdate('cascade')->nullable();
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
