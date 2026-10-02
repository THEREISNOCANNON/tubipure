<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCustomerAddressRequest;
use App\Models\CustomerAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerAddressController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        abort_unless($request->user()->role === 'customer' && $request->user()->customer, 403);
        $customer = $request->user()->customer;

        if ($customer->addresses()->doesntExist() && filled($customer->address)) {
            $customer->addresses()->create([
                'label' => 'Home',
                'address' => $customer->address,
                'is_default' => true,
            ]);
        }

        return response()->json([
            'data' => $customer->addresses()->orderBy('id')->get()->map(fn (CustomerAddress $address): array => $this->addressData($address)),
        ]);
    }

    public function store(SaveCustomerAddressRequest $request): JsonResponse
    {
        $customer = $request->user()->customer;

        $address = DB::transaction(function () use ($customer, $request): CustomerAddress {
            $customer->newQuery()->lockForUpdate()->findOrFail($customer->id);
            $existingAddresses = $customer->addresses()->count();
            abort_if($existingAddresses >= 5, 422, 'You can save up to five addresses.');

            $address = $customer->addresses()->create([
                ...$request->validated(),
                'is_default' => $existingAddresses === 0,
            ]);

            if ($address->is_default) {
                $customer->update(['address' => $address->address]);
            }

            return $address;
        });

        return response()->json(['data' => $this->addressData($address)], 201);
    }

    public function update(SaveCustomerAddressRequest $request, CustomerAddress $address): JsonResponse
    {
        abort_unless($address->customer_id === $request->user()->customer->id, 404);

        $address->update($request->validated());

        if ($address->is_default) {
            $address->customer()->update(['address' => $address->address]);
        }

        return response()->json(['data' => $this->addressData($address)]);
    }

    public function setDefault(Request $request, CustomerAddress $address): JsonResponse
    {
        abort_unless($request->user()->role === 'customer' && $request->user()->customer, 403);
        abort_unless($address->customer_id === $request->user()->customer->id, 404);

        DB::transaction(function () use ($address, $request): void {
            $customer = $request->user()->customer;
            $customer->newQuery()->lockForUpdate()->findOrFail($customer->id);
            $customer->addresses()->update(['is_default' => false]);
            $address->update(['is_default' => true]);
            $customer->update(['address' => $address->address]);
        });

        return response()->json(['data' => $this->addressData($address->refresh())]);
    }

    public function destroy(Request $request, CustomerAddress $address): JsonResponse
    {
        abort_unless($request->user()->role === 'customer' && $request->user()->customer, 403);
        abort_unless($address->customer_id === $request->user()->customer->id, 404);

        DB::transaction(function () use ($address, $request): void {
            $customer = $request->user()->customer;
            $customer->newQuery()->lockForUpdate()->findOrFail($customer->id);
            $address->delete();

            $defaultAddress = $customer->addresses()->orderByDesc('is_default')->orderBy('id')->first();
            $customer->addresses()->update(['is_default' => false]);

            if ($defaultAddress) {
                $defaultAddress->update(['is_default' => true]);
                $customer->update(['address' => $defaultAddress->address]);
            } else {
                $customer->update(['address' => '']);
            }
        });

        return response()->json(['message' => 'Address deleted.']);
    }

    /** @return array{id: int, label: string, address: string, latitude: ?float, longitude: ?float, is_default: bool} */
    private function addressData(CustomerAddress $address): array
    {
        return [
            'id' => $address->id,
            'label' => $address->label,
            'address' => $address->address,
            'latitude' => $address->latitude,
            'longitude' => $address->longitude,
            'is_default' => $address->is_default,
        ];
    }
}
