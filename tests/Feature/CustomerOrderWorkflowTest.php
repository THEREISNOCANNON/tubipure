<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerOrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_order_uses_saved_address_and_server_calculates_quantity_and_price(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => 'Saved address',
            'contact' => '09123456789',
        ]);
        $address = $customer->addresses()->create([
            'label' => 'Home',
            'address' => 'Purok Pioneer, Tagum City',
            'latitude' => 7.4288167,
            'longitude' => 125.7984943,
            'is_default' => true,
        ]);

        $response = $this->actingAs($user)->postJson('/api/my/orders', [
            'water_selection' => 'both',
            'container_size_gallons' => 3,
            'alkaline_quantity' => 2,
            'purified_quantity' => 1,
            'fulfillment_method' => 'delivery',
            'payment_method' => 'cash_on_delivery',
            'date' => now()->addDay()->toDateString(),
            'time_slot' => '08:00',
            'contact_name' => $user->name,
            'contact_phone' => '09123456789',
            'delivery_address' => $address->id,
            'gallons' => 1,
            'order_total' => 1,
            'delivery_zone' => 'C',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.gallons', 9)
            ->assertJsonPath('data.alkaline_quantity', 2)
            ->assertJsonPath('data.purified_quantity', 1)
            ->assertJsonPath('data.delivery_zone', 'A')
            ->assertJsonPath('data.delivery_address', 'Purok Pioneer, Tagum City')
            ->assertJsonPath('data.water_subtotal', '375.00')
            ->assertJsonPath('data.delivery_fee', '0.00')
            ->assertJsonPath('data.order_total', '375.00');

        $this->assertDatabaseHas('deliveries', [
            'customer_id' => $customer->id,
            'gallons' => 9,
            'order_total' => 375,
            'status' => 'Pending',
        ]);
    }

    public function test_pickup_order_has_no_delivery_fee_or_address(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => '',
            'contact' => '09123456789',
        ]);

        $response = $this->actingAs($user)->postJson('/api/my/orders', [
            'water_selection' => 'alkaline',
            'container_size_gallons' => 1,
            'quantity' => 2,
            'fulfillment_method' => 'pickup',
            'payment_method' => 'cash_on_delivery',
            'date' => now()->addDay()->toDateString(),
            'time_slot' => '08:00',
            'contact_name' => $user->name,
            'contact_phone' => '09123456789',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.fulfillment_method', 'pickup')
            ->assertJsonPath('data.delivery_address', null)
            ->assertJsonPath('data.delivery_distance_km', null)
            ->assertJsonPath('data.delivery_fee', '0.00')
            ->assertJsonPath('data.order_total', '100.00');

        $this->assertDatabaseHas('deliveries', [
            'customer_id' => $customer->id,
            'fulfillment_method' => 'pickup',
            'delivery_fee' => 0,
            'order_total' => 100,
        ]);
    }

    public function test_customer_cannot_place_delivery_order_using_another_customers_address(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => '',
            'contact' => '09123456789',
        ]);
        $otherCustomer = Customer::query()->create([
            'name' => 'Other customer',
            'email' => 'other@example.test',
            'address' => 'Other address',
            'contact' => '09999999999',
        ]);
        $otherAddress = $otherCustomer->addresses()->create([
            'label' => 'Home',
            'address' => 'Other address',
            'latitude' => 7.4288167,
            'longitude' => 125.7984943,
        ]);

        $response = $this->actingAs($user)->postJson('/api/my/orders', [
            'water_selection' => 'purified',
            'container_size_gallons' => 1,
            'quantity' => 1,
            'fulfillment_method' => 'delivery',
            'payment_method' => 'cash_on_delivery',
            'date' => now()->addDay()->toDateString(),
            'time_slot' => '08:00',
            'contact_name' => $user->name,
            'contact_phone' => '09123456789',
            'delivery_address' => $otherAddress->id,
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors('delivery_address');
        $this->assertSame(0, Delivery::query()->where('customer_id', $customer->id)->count());
    }

    public function test_customer_delivery_outside_the_service_area_is_rejected(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => '',
            'contact' => '09123456789',
        ]);
        $address = $customer->addresses()->create([
            'label' => 'Outside area',
            'address' => 'Tagum City',
            'latitude' => 7.4478,
            'longitude' => 125.8078,
        ]);

        $response = $this->actingAs($user)->postJson('/api/my/orders', [
            'water_selection' => 'purified',
            'container_size_gallons' => 1,
            'quantity' => 1,
            'fulfillment_method' => 'delivery',
            'payment_method' => 'cash_on_delivery',
            'date' => now()->addDay()->toDateString(),
            'time_slot' => '08:00',
            'contact_name' => $user->name,
            'contact_phone' => '09123456789',
            'delivery_address' => $address->id,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('delivery_address')
            ->assertJsonPath('errors.delivery_address.0', 'Delivery is available only within Visayan Village, Tagum City. Choose pickup or select an address within the delivery area.');
        $this->assertSame(0, Delivery::query()->where('customer_id', $customer->id)->count());
    }

    public function test_customer_cannot_schedule_delivery_after_delivery_hours(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => '',
            'contact' => '09123456789',
        ]);
        $address = $customer->addresses()->create([
            'label' => 'Home',
            'address' => 'Purok Pioneer, Tagum City',
            'latitude' => 7.4288167,
            'longitude' => 125.7984943,
        ]);

        $response = $this->actingAs($user)->postJson('/api/my/orders', [
            'water_selection' => 'purified',
            'container_size_gallons' => 1,
            'quantity' => 1,
            'fulfillment_method' => 'delivery',
            'payment_method' => 'cash_on_delivery',
            'date' => now()->addDay()->toDateString(),
            'time_slot' => '17:00',
            'contact_name' => $user->name,
            'contact_phone' => '09123456789',
            'delivery_address' => $address->id,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('time_slot')
            ->assertJsonPath('errors.time_slot.0', 'Choose a time between 07:00 and 16:00 on '.now()->addDay()->format('l').'.');
        $this->assertSame(0, Delivery::query()->where('customer_id', $customer->id)->count());
    }

    public function test_staff_order_approval_is_visible_in_customer_order_tracking(): void
    {
        $customerUser = User::factory()->create(['role' => 'customer']);
        $customer = $customerUser->customer()->create([
            'name' => $customerUser->name,
            'email' => $customerUser->email,
            'address' => 'Home address',
            'contact' => '09123456789',
        ]);
        $delivery = $customer->deliveries()->create([
            'date' => now()->addDay()->toDateString(),
            'time_slot' => '08:00',
            'gallons' => 1,
            'status' => 'Pending',
            'fulfillment_method' => 'pickup',
        ]);
        $staffUser = User::factory()->create(['role' => 'staff']);

        $this->actingAs($staffUser)
            ->patchJson("/api/staff/deliveries/{$delivery->id}/status", ['status' => 'Confirmed'])
            ->assertOk()
            ->assertJsonPath('data.status', 'Confirmed');

        $this->actingAs($customerUser)
            ->getJson('/api/my/orders')
            ->assertOk()
            ->assertJsonPath('data.0.id', $delivery->id)
            ->assertJsonPath('data.0.status', 'Confirmed');

        $this->assertDatabaseHas('deliveries', ['id' => $delivery->id, 'status' => 'Confirmed']);
    }

    public function test_non_staff_customer_cannot_approve_orders(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $this->actingAs($user)->getJson('/api/staff/dashboard')->assertForbidden();
    }
}
