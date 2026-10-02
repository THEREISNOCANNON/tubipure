<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'customer_address_id', 'date', 'time_slot', 'gallons', 'status', 'water_type',
        'container_size_gallons', 'quantity', 'alkaline_quantity', 'purified_quantity', 'fulfillment_method', 'payment_method', 'delivery_zone',
        'rate_per_gallon', 'alkaline_rate_per_gallon', 'purified_rate_per_gallon',
        'delivery_rate_per_km', 'delivery_distance_km', 'water_subtotal', 'delivery_fee',
        'order_total', 'contact_name', 'contact_phone',
        'delivery_address', 'delivery_latitude', 'delivery_longitude', 'delivery_instructions', 'status_note',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d',
            'gallons' => 'integer',
            'container_size_gallons' => 'integer',
            'quantity' => 'integer',
            'alkaline_quantity' => 'integer',
            'purified_quantity' => 'integer',
            'rate_per_gallon' => 'decimal:2',
            'alkaline_rate_per_gallon' => 'decimal:2',
            'purified_rate_per_gallon' => 'decimal:2',
            'delivery_rate_per_km' => 'decimal:2',
            'delivery_distance_km' => 'decimal:2',
            'delivery_latitude' => 'decimal:7',
            'delivery_longitude' => 'decimal:7',
            'water_subtotal' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'order_total' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerAddress(): BelongsTo
    {
        return $this->belongsTo(CustomerAddress::class);
    }
}
