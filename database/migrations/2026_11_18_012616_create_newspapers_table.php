<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newspapers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('language')->default('bangla'); // bangla, english
            $table->string('logo')->nullable();
            $table->decimal('classified_rate_per_word', 8, 2)->default(12.00); // BDT per word
            $table->decimal('display_rate_col_inch', 10, 2)->default(1200.00); // BDT per col-inch
            $table->decimal('front_page_multiplier', 4, 2)->default(2.50);
            $table->decimal('back_page_multiplier', 4, 2)->default(1.80);
            $table->decimal('inner_page_multiplier', 4, 2)->default(1.00);
            $table->integer('color_charge_percent')->default(30); // 30% extra for colored
            $table->integer('min_words')->default(20);
            $table->string('contact_email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newspapers');
    }
};
