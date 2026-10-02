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
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });

        DB::table('customers')
            ->select(['id', 'address'])
            ->orderBy('id')
            ->chunkById(100, function ($customers): void {
                foreach ($customers as $customer) {
                    $preferredAddress = filled($customer->address)
                        ? DB::table('customer_addresses')
                            ->where('customer_id', $customer->id)
                            ->where('address', $customer->address)
                            ->orderBy('id')
                            ->first()
                        : null;

                    $preferredAddress ??= DB::table('customer_addresses')
                        ->where('customer_id', $customer->id)
                        ->orderBy('id')
                        ->first();

                    if ($preferredAddress) {
                        DB::table('customer_addresses')
                            ->where('id', $preferredAddress->id)
                            ->update(['is_default' => true]);
                    }
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
};
