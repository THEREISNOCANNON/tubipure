<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pricing_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('alkaline_price_per_gallon', 8, 2);
            $table->decimal('purified_price_per_gallon', 8, 2);
            $table->decimal('delivery_price_per_km', 8, 2);
            $table->timestamps();
        });

        DB::table('pricing_settings')->insert([
            'id' => 1,
            'alkaline_price_per_gallon' => 50,
            'purified_price_per_gallon' => 25,
            'delivery_price_per_km' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_settings');
    }
};
