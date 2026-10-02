<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $customers = Customer::query()
            ->where('is_archived', false)
            ->withCount('deliveries')
            ->with('deliveries')
            ->when($request->string('search')->isNotEmpty(), function ($query) use ($request): void {
                $search = $request->string('search')->toString();
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('contact', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->get()
            ->map(fn (Customer $customer): array => $this->customerData($customer));

        return response()->json(['data' => $customers]);
    }

    public function store(SaveCustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->validated());

        return response()->json(['data' => $this->customerData($customer)], 201);
    }

    public function update(SaveCustomerRequest $request, Customer $customer): JsonResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($customer, $data): void {
            $customer->update($data);
            $customer->user?->update(['name' => $data['name']]);
        });

        return response()->json(['data' => $this->customerData($customer->load('deliveries'))]);
    }

    public function archiveRecord(Customer $customer): JsonResponse
    {
        $customer->forceFill(['is_archived' => true])->save();

        return response()->json(['message' => 'Customer removed from records.']);
    }

    /**
     * @return array<string, mixed>
     */
    private function customerData(Customer $customer): array
    {
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'address' => $customer->address,
            'contact' => $customer->contact,
            'orderCount' => $customer->deliveries_count ?? $customer->deliveries->count(),
            'history' => $customer->deliveries->map(fn ($delivery): array => [
                'date' => $delivery->date->format('Y-m-d'),
                'gallons' => $delivery->gallons,
                'status' => $delivery->status,
            ])->values()->all(),
        ];
    }
}
