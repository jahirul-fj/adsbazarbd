<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('design_orders', function (Blueprint $table) {
            $table->decimal('platform_commission_percent', 5, 2)->default(15.00)->after('budget');
            $table->decimal('platform_commission_amount', 10, 2)->default(0.00)->after('platform_commission_percent');
            $table->decimal('designer_earning', 10, 2)->default(0.00)->after('platform_commission_amount');
        });
    }

    public function down(): void
    {
        Schema::table('design_orders', function (Blueprint $table) {
            $table->dropColumn([
                'platform_commission_percent',
                'platform_commission_amount',
                'designer_earning',
            ]);
        });
    }
};
