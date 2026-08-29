<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Issue #6 & Business User Creation: Database table to store business entities.
     */
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('bengali_name')->nullable();
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->float('rating')->default(0.0);
            $table->integer('review_count')->default(0);
            $table->boolean('verified')->default(false);
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_url')->nullable(); // Facebook page URL field
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->json('branches')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
