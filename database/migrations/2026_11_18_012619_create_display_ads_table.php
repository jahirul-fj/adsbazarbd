<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('display_ads', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_no')->unique(); // e.g. DSP-2026-0001
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->foreignId('newspaper_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ad_category_id')->nullable()->constrained()->nullOnDelete();
            $table->date('publish_date');
            $table->string('title');
            $table->string('page_position')->default('inner_page'); // front_page, back_page, inner_page
            $table->string('color_type')->default('color'); // color, black_white
            $table->integer('columns')->default(1);
            $table->decimal('height_inches', 6, 2)->default(2.00);
            $table->decimal('total_col_inches', 6, 2)->default(2.00);
            $table->decimal('rate_applied', 10, 2)->default(0.00);
            $table->string('artwork_file')->nullable();
            $table->boolean('needs_designer')->default(false);
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->string('payment_method')->default('bkash');
            $table->string('payment_trx_id')->nullable();
            $table->string('payment_sender_phone')->nullable();
            $table->string('payment_status')->default('pending_verification'); // unpaid, pending_verification, paid, rejected
            $table->string('status')->default('pending'); // pending, in_review, approved, published, rejected
            $table->string('published_proof_url')->nullable();
            $table->string('published_proof_image')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('display_ads');
    }
};
