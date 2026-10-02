<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingSetting extends Model
{
    protected $fillable = [
        'alkaline_price_per_gallon',
        'purified_price_per_gallon',
        'delivery_price_per_km',
        'opening_time',
        'closing_time',
        'delivery_start_time',
        'delivery_end_time',
        'station_schedule',
        'delivery_schedule',
    ];

    protected function casts(): array
    {
        return [
            'alkaline_price_per_gallon' => 'decimal:2',
            'purified_price_per_gallon' => 'decimal:2',
            'delivery_price_per_km' => 'decimal:2',
            'station_schedule' => 'array',
            'delivery_schedule' => 'array',
        ];
    }
}
