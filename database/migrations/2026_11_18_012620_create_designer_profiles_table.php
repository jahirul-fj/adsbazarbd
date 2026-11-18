<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('designer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tagline')->nullable(); // e.g. পেশাদার নিউজপেপার ও কমার্শিয়াল গ্রাফিক ডিজাইনার
            $table->text('about')->nullable();
            $table->integer('experience_years')->default(3);
            $table->decimal('starting_rate', 10, 2)->default(500.00); // BDT per artwork
            $table->text('skills')->nullable(); // comma-separated or json
            $table->text('portfolio')->nullable(); // json array of portfolio works
            $table->integer('completed_orders')->default(0);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('total_reviews')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designer_profiles');
    }
};
