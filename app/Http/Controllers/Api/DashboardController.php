<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'customers' => Customer::query()->with('deliveries')->orderBy('name')->get()->map(function (Customer $customer): array {
                $history = $customer->deliveries
                    ->sortByDesc('date')
                    ->values();

                return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'address' => $customer->address,
                    'contact' => $customer->contact,
                    'userId' => $customer->user_id,
                    'isArchived' => $customer->is_archived,
                    'isActive' => $customer->user_id !== null,
                    'createdAt' => $customer->created_at?->toIso8601String(),
                    'orderCount' => $history->count(),
                    'pendingOrderCount' => $history->where('status', 'Pending')->count(),
                    'lastOrderDate' => $history->first()?->date->format('Y-m-d'),
                    'totalGallons' => $history->sum('gallons'),
                    'totalSpent' => $history->sum('order_total'),
                    'history' => $history->map(fn (Delivery $delivery): array => [
                        'id' => $delivery->id,
                        'date' => $delivery->date->format('Y-m-d'),
                        'time' => $delivery->time_slot,
                        'gallons' => $delivery->gallons,
                        'orderTotal' => $delivery->order_total,
                        'status' => $delivery->status,
                        'statusNote' => $delivery->status_note,
                    ])->all(),
                ];
            }),
            'deliveries' => Delivery::query()->with([
                'customer:id,name,address,contact',
                'customer.addresses:id,customer_id,address,latitude,longitude,is_default',
                'customerAddress:id,customer_id,address,latitude,longitude,is_default',
            ])->orderBy('date')->get()->map(function (Delivery $delivery): array {
                $matchingAddresses = $delivery->customer?->addresses
                    ->filter(fn (CustomerAddress $customerAddress): bool => mb_strtolower(trim($customerAddress->address)) === mb_strtolower(trim((string) $delivery->delivery_address)))
                    ->values() ?? collect();
                $matchingAddress = $matchingAddresses->first(function (CustomerAddress $customerAddress) use ($delivery): bool {
                    return $delivery->delivery_latitude !== null && $delivery->delivery_longitude !== null
                        && $customerAddress->latitude !== null && $customerAddress->longitude !== null
                        && abs((float) $customerAddress->latitude - (float) $delivery->delivery_latitude) <= 0.0000001
                        && abs((float) $customerAddress->longitude - (float) $delivery->delivery_longitude) <= 0.0000001;
                }) ?? ($matchingAddresses->count() === 1
                    ? $matchingAddresses->first()
                    : $matchingAddresses->firstWhere('is_default', true));
                $customerAddresses = $delivery->customer?->addresses ?? collect();
                $savedAddress = $delivery->fulfillment_method === 'delivery'
                    ? ($delivery->customerAddress
                        ?? $matchingAddress
                        ?? $customerAddresses->firstWhere('is_default', true)
                        ?? ($customerAddresses->count() === 1 ? $customerAddresses->first() : null))
                    : null;
                $hasSavedOrderCoordinates = $delivery->delivery_latitude !== null && $delivery->delivery_longitude !== null;

                return [
                    'id' => $delivery->id,
                    'customerId' => $delivery->customer_id,
                    'customerAddressId' => $delivery->customer_address_id,
                    'createdAt' => $delivery->created_at?->toIso8601String(),
                    'updatedAt' => $delivery->updated_at?->toIso8601String(),
                    'date' => $delivery->date->format('Y-m-d'),
                    'time' => $delivery->time_slot,
                    'gallons' => $delivery->gallons,
                    'status' => $delivery->status,
                    'statusNote' => $delivery->status_note,
                    'address' => $savedAddress?->address ?? $delivery->delivery_address ?? $delivery->customer?->address,
                    'waterType' => $delivery->water_type,
                    'waterTypes' => $delivery->water_type ? explode(',', $delivery->water_type) : [],
                    'containerSizeGallons' => $delivery->container_size_gallons,
                    'quantity' => $delivery->quantity,
                    'alkalineQuantity' => $delivery->alkaline_quantity,
                    'purifiedQuantity' => $delivery->purified_quantity,
                    'fulfillmentMethod' => $delivery->fulfillment_method,
                    'deliveryZone' => $delivery->delivery_zone,
                    'ratePerGallon' => $delivery->rate_per_gallon,
                    'alkalineRatePerGallon' => $delivery->alkaline_rate_per_gallon,
                    'purifiedRatePerGallon' => $delivery->purified_rate_per_gallon,
                    'deliveryRatePerKm' => $delivery->delivery_rate_per_km,
                    'deliveryDistanceKm' => $delivery->delivery_distance_km,
                    'waterSubtotal' => $delivery->water_subtotal,
                    'deliveryFee' => $delivery->delivery_fee,
                    'orderTotal' => $delivery->order_total,
                    'contactName' => $delivery->contact_name,
                    'contactPhone' => $delivery->contact_phone,
                    'deliveryAddress' => $savedAddress?->address ?? $delivery->delivery_address,
                    'deliveryLatitude' => $savedAddress?->latitude ?? ($hasSavedOrderCoordinates ? $delivery->delivery_latitude : null),
                    'deliveryLongitude' => $savedAddress?->longitude ?? ($hasSavedOrderCoordinates ? $delivery->delivery_longitude : null),
                    'deliveryInstructions' => $delivery->delivery_instructions,
                    'customer' => $delivery->customer ? ['id' => $delivery->customer->id, 'name' => $delivery->customer->name] : null,
                ];
            }),
        ]);
    }

    public function publicStats(): JsonResponse
    {
        $weekAgo = now()->subDays(7)->toDateString();

        return response()->json([
            'customers' => Customer::query()->count(),
            'today' => Delivery::query()->whereDate('date', today())->where('status', '!=', 'Cancelled')->count(),
            'gallons' => Delivery::query()->whereBetween('date', [$weekAgo, today()])->where('status', 'Delivered')->sum('gallons'),
        ]);
    }
}
