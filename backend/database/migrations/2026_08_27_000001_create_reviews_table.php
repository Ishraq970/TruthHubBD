<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Issue #3 (Optional location), Issue #4 (Facebook URL), Issue #5 (File Upload):
     * Database table for community reviews.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->string('author');
            $table->string('initials')->nullable();
            $table->integer('rating');
            $table->string('title');
            $table->text('body');
            $table->string('date')->nullable();
            $table->string('disclaimer')->nullable();
            $table->boolean('verified_experience')->default(true);
            
            // Issue #3: Location field is optional (nullable)
            $table->string('location')->nullable();
            
            // Issue #4: Facebook page URL field is optional (nullable)
            $table->string('facebook_url')->nullable();
            
            // Issue #5: Uploaded file / receipt photo path is optional (nullable)
            $table->string('image_path')->nullable();
            
            $table->integer('helpful_count')->default(0);
            $table->integer('discussion_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
