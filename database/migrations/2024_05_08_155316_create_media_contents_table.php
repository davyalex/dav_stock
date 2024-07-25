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
        Schema::create('media_contents', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->nullable();
            $table->longText('slug')->nullable();
            $table->string('status')->nullable();
            $table->string('url')->nullable();


            $table->foreignId('media_categories_id')
                ->nullable()
                ->constrained('media_categories')
                ->onUpdate('cascade')
                ->onDelete('set null');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_contents');
    }
};
