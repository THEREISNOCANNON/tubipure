<?php

namespace Tests\Feature;

use App\Models\CustomerAddress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerAddressWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_includes_saved_address_coordinates_for_delivery_coverage(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => 'Purok Pioneer, Tagum City',
            'contact' => '09123456789',
        ]);
        $customer->addresses()->create([
            'label' => 'Home',
            'address' => 'Purok Pioneer, Tagum City',
            'latitude' => 7.4288167,
            'longitude' => 125.7984943,
            'is_default' => true,
        ]);

        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'password'])
            ->assertOk()
            ->assertJsonPath('user.customer.addresses.0.latitude', 7.4288167)
            ->assertJsonPath('user.customer.addresses.0.longitude', 125.7984943);
    }

    public function test_first_saved_address_becomes_the_default_address(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => '',
            'contact' => '09123456789',
        ]);

        $response = $this->actingAs($user)->postJson('/api/my/addresses', [
            'label' => 'Home',
            'address' => 'Purok Pioneer, Tagum City',
            'latitude' => 7.4288167,
            'longitude' => 125.7984943,
        ]);

        $response->assertCreated()->assertJsonPath('data.is_default', true);
        $this->assertDatabaseHas('customer_addresses', [
            'customer_id' => $customer->id,
            'is_default' => true,
        ]);
        $this->assertSame('Purok Pioneer, Tagum City', $customer->refresh()->address);
    }

    public function test_customer_can_change_default_address_and_other_addresses_are_unset(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => 'Old address',
            'contact' => '09123456789',
        ]);
        $oldAddress = $customer->addresses()->create([
            'label' => 'Home',
            'address' => 'Old address',
            'latitude' => 7.4288167,
            'longitude' => 125.7984943,
            'is_default' => true,
        ]);
        $newAddress = $customer->addresses()->create([
            'label' => 'Work',
            'address' => 'New address',
            'latitude' => 7.429,
            'longitude' => 125.799,
            'is_default' => false,
        ]);

        $response = $this->actingAs($user)->patchJson("/api/my/addresses/{$newAddress->id}/default");

        $response->assertOk()->assertJsonPath('data.is_default', true);
        $this->assertDatabaseHas('customer_addresses', ['id' => $oldAddress->id, 'is_default' => false]);
        $this->assertDatabaseHas('customer_addresses', ['id' => $newAddress->id, 'is_default' => true]);
        $this->assertSame('New address', $customer->refresh()->address);
        $this->actingAs($user)->getJson('/api/my/addresses')->assertJsonPath('data.1.is_default', true);
    }

    public function test_customer_cannot_change_another_customers_default_address(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $owner = User::factory()->create(['role' => 'customer']);
        $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => '',
            'contact' => '09123456789',
        ]);
        $customer = $owner->customer()->create([
            'name' => $owner->name,
            'email' => $owner->email,
            'address' => 'Private address',
            'contact' => '09123456789',
        ]);
        $address = $customer->addresses()->create([
            'label' => 'Home',
            'address' => 'Private address',
            'latitude' => 7.4288167,
            'longitude' => 125.7984943,
        ]);

        $this->actingAs($user)->patchJson("/api/my/addresses/{$address->id}/default")->assertNotFound();
        $this->assertDatabaseHas('customer_addresses', ['id' => $address->id, 'is_default' => false]);
    }

    public function test_deleting_default_address_promotes_another_saved_address(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => 'Home address',
            'contact' => '09123456789',
        ]);
        $defaultAddress = $customer->addresses()->create([
            'label' => 'Home',
            'address' => 'Home address',
            'latitude' => 7.4288167,
            'longitude' => 125.7984943,
            'is_default' => true,
        ]);
        $otherAddress = $customer->addresses()->create([
            'label' => 'Work',
            'address' => 'Work address',
            'latitude' => 7.429,
            'longitude' => 125.799,
            'is_default' => false,
        ]);

        $this->actingAs($user)->deleteJson("/api/my/addresses/{$defaultAddress->id}")->assertOk();

        $this->assertDatabaseMissing('customer_addresses', ['id' => $defaultAddress->id]);
        $this->assertDatabaseHas('customer_addresses', ['id' => $otherAddress->id, 'is_default' => true]);
        $this->assertSame('Work address', $customer->refresh()->address);
    }

    public function test_address_list_rejects_a_sixth_saved_address(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $customer = $user->customer()->create([
            'name' => $user->name,
            'email' => $user->email,
            'address' => 'Home address',
            'contact' => '09123456789',
        ]);
        foreach (range(1, 5) as $number) {
            $customer->addresses()->create([
                'label' => "Address {$number}",
                'address' => "Saved address {$number}",
                'latitude' => 7.4288167,
                'longitude' => 125.7984943,
                'is_default' => $number === 1,
            ]);
        }

        $response = $this->actingAs($user)->postJson('/api/my/addresses', [
            'label' => 'Extra',
            'address' => 'Extra address',
            'latitude' => 7.4288167,
            'longitude' => 125.7984943,
        ]);

        $response->assertUnprocessable()->assertJsonPath('message', 'You can save up to five addresses.');
        $this->assertSame(5, CustomerAddress::query()->where('customer_id', $customer->id)->count());
    }
}
