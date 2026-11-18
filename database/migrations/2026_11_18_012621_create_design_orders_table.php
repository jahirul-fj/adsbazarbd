<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('design_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique(); // e.g. DSN-2026-0001
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('designer_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('brief_description');
            $table->string('ad_size_requirement')->nullable(); // e.g. 4 Col x 5 Inch
            $table->string('attachment_file')->nullable();
            $table->decimal('budget', 10, 2)->default(500.00);
            $table->integer('revisions_remaining')->default(3);
            $table->string('status')->default('in_progress'); // in_progress, draft_submitted, revision_requested, completed, cancelled
            $table->boolean('escrow_funded')->default(true);
            $table->string('final_delivery_file')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->text('review_comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('design_orders');
    }
};
