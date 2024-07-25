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
        Schema::create('blog_contents', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->nullable();
            $table->longText('slug')->nullable();
            $table->longText('resume')->nullable(); // resume of description
            $table->longText('description')->nullable();
            $table->string('status')->nullable();

            $table->foreignId('blog_categories_id')
                ->nullable()
                ->constrained('blog_categories')
                ->onUpdate('cascade')
                ->onDelete('set null');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_contents');
    }
};
