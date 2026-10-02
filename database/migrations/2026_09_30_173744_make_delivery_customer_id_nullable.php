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
        Schema::table('deliveries', function (Blueprint $table): void {
            $table->foreignId('customer_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('deliveries')->whereNull('customer_id')->exists()) {
            throw new LogicException('Cannot require a customer while walk-in order records have no customer.');
        }

        Schema::table('deliveries', function (Blueprint $table): void {
            $table->foreignId('customer_id')->nullable(false)->change();
        });
    }
};
