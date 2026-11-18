<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classified_ads', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_no')->unique(); // e.g. CLS-2026-0001
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->foreignId('newspaper_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ad_category_id')->constrained()->cascadeOnDelete();
            $table->date('publish_date');
            $table->string('title');
            $table->text('ad_body');
            $table->integer('word_count')->default(0);
            $table->string('document_file')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->string('payment_method')->default('bkash'); // bkash, nagad, rocket, bank, cash_pickup
            $table->string('payment_trx_id')->nullable();
            $table->string('payment_sender_phone')->nullable();
            $table->string('payment_status')->default('pending_verification'); // unpaid, pending_verification, paid, rejected
            $table->string('status')->default('pending'); // pending, approved, published, rejected
            $table->string('published_proof_url')->nullable();
            $table->string('published_proof_image')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classified_ads');
    }
};
