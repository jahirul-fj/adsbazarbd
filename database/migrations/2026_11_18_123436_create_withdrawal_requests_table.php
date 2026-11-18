<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_no')->unique(); // e.g. WTH-202611-1001
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method'); // bkash, nagad, rocket, bank
            $table->string('account_number');
            $table->text('account_details')->nullable(); // bank name, branch, etc.
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('trx_id')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
