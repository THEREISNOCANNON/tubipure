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
            $table->string('water_type', 20)->nullable();
            $table->unsignedTinyInteger('container_size_gallons')->nullable();
            $table->unsignedSmallInteger('quantity')->nullable();
            $table->string('fulfillment_method', 20)->default('delivery');
            $table->char('delivery_zone', 1)->nullable();
            $table->decimal('rate_per_gallon', 8, 2)->nullable();
            $table->decimal('order_total', 10, 2)->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone', 40)->nullable();
            $table->string('delivery_address')->nullable();
            $table->text('delivery_instructions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropColumn([
                'water_type', 'container_size_gallons', 'quantity', 'fulfillment_method',
                'delivery_zone', 'rate_per_gallon', 'order_total', 'contact_name',
                'contact_phone', 'delivery_address', 'delivery_instructions',
            ]);
        });
    }
};
