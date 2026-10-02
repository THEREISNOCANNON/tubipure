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
        Schema::table('deliveries', function (Blueprint $table) {
            $table->foreignId('customer_address_id')
                ->nullable()
                ->after('customer_id')
                ->constrained('customer_addresses')
                ->nullOnDelete();
        });

        $deliveries = DB::table('deliveries')
            ->where('fulfillment_method', 'delivery')
            ->whereNotNull('customer_id')
            ->whereNotNull('delivery_address')
            ->get(['id', 'customer_id', 'delivery_address', 'delivery_latitude', 'delivery_longitude']);
        $addressesByCustomer = DB::table('customer_addresses')
            ->whereIn('customer_id', $deliveries->pluck('customer_id')->unique())
            ->get(['id', 'customer_id', 'address', 'latitude', 'longitude', 'is_default'])
            ->groupBy('customer_id');

        foreach ($deliveries as $delivery) {
            $matchingAddresses = $addressesByCustomer->get($delivery->customer_id, collect())
                ->filter(fn (object $address): bool => mb_strtolower(trim($address->address)) === mb_strtolower(trim($delivery->delivery_address)))
                ->values();
            $matchingAddress = null;

            if ($delivery->delivery_latitude !== null && $delivery->delivery_longitude !== null) {
                $matchingAddress = $matchingAddresses->first(fn (object $address): bool => $address->latitude !== null && $address->longitude !== null
                    && abs((float) $address->latitude - (float) $delivery->delivery_latitude) <= 0.0000001
                    && abs((float) $address->longitude - (float) $delivery->delivery_longitude) <= 0.0000001);
            }

            $matchingAddress ??= $matchingAddresses->count() === 1
                ? $matchingAddresses->first()
                : $matchingAddresses->firstWhere('is_default', true);

            if ($matchingAddress !== null) {
                DB::table('deliveries')->where('id', $delivery->id)->update(['customer_address_id' => $matchingAddress->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliveries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_address_id');
        });
    }
};
