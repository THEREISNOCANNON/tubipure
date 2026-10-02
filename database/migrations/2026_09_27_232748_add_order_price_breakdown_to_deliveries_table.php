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
        Schema::table('deliveries', function (Blueprint $table) {
            $table->decimal('alkaline_rate_per_gallon', 8, 2)->nullable()->after('rate_per_gallon');
            $table->decimal('purified_rate_per_gallon', 8, 2)->nullable()->after('alkaline_rate_per_gallon');
            $table->decimal('delivery_rate_per_km', 8, 2)->nullable()->after('purified_rate_per_gallon');
            $table->decimal('delivery_distance_km', 8, 2)->nullable()->after('delivery_rate_per_km');
            $table->decimal('water_subtotal', 10, 2)->nullable()->after('delivery_distance_km');
            $table->decimal('delivery_fee', 10, 2)->nullable()->after('water_subtotal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn([
                'alkaline_rate_per_gallon', 'purified_rate_per_gallon', 'delivery_rate_per_km',
                'delivery_distance_km', 'water_subtotal', 'delivery_fee',
            ]);
        });
    }
};
