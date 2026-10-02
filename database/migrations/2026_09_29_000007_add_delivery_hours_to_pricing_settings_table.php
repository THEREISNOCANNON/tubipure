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
        Schema::table('pricing_settings', function (Blueprint $table) {
            $table->time('opening_time')->default('06:00:00');
            $table->time('closing_time')->default('18:00:00');
            $table->time('delivery_start_time')->default('07:00:00');
            $table->time('delivery_end_time')->default('16:00:00');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pricing_settings', function (Blueprint $table) {
            $table->dropColumn([
                'opening_time',
                'closing_time',
                'delivery_start_time',
                'delivery_end_time',
            ]);
        });
    }
};
