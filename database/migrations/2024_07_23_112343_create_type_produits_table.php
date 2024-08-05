<?php

use App\Models\TypeProduit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_produits', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->string('slug')->nullable();
            $table->string('url')->nullable();
            $table->string('status')->nullable();
            $table->integer('position')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_produits');
    }
};
