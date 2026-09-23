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
        Schema::create('board_members', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bn')->nullable();
            $table->string('designation_en');
            $table->string('designation_bn')->nullable();
            $table->enum('type', ['chairman', 'director', 'advisor'])->default('director');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('bio_en')->nullable();
            $table->text('bio_bn')->nullable();
            $table->string('image')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_instagram')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_members');
    }
};
