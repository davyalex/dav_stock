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
        Schema::create('billetteries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caisse_id')->nullable()->constrained('caisses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('mode'); // 0: Espèce, 1: Mobile Money
            $table->string('type_monnaie')->nullable(); // Billets ou Pièces (si espèce)
            $table->integer('quantite')->nullable();
            $table->double('valeur')->nullable();
            $table->string('type_mobile_money')->nullable();
            $table->double('montant')->nullable(); // Montant en mobile money
            $table->double('total'); // Total général par ligne
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billetteries');
    }
};
