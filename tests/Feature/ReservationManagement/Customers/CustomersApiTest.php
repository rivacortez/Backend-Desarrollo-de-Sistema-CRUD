<?php

namespace Tests\Feature\ReservationManagement\Customers;

use App\ReservationManagement\Customers\domain\model\aggregates\Customers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomersApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_get_all_customers(): void
    {
        Customers::factory()->count(3)->create();

        $this->getJson(route('customers.index'))
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    ['id', 'nombre', 'correo', 'telefono', 'direccion', 'created_at', 'updated_at']
                ]
            ]);
    }

    public function test_can_get_customer_by_id(): void
    {
        $customer = Customers::factory()->create();

        $this->getJson(route('customers.show', $customer))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $customer->id,
                    'nombre' => $customer->nombre,
                    'correo' => $customer->correo,
                ]
            ]);
    }

    public function test_getting_non_existent_customer_returns_404(): void
    {
        $this->getJson('/api/customers/999')
            ->assertStatus(404);
    }

    public function test_can_create_customer(): void
    {
        $customerData = [
            'nombre' => $this->faker->name(),
            'correo' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
        ];

        $this->postJson(route('customers.store'), $customerData)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'nombre', 'correo', 'telefono', 'direccion', 'created_at', 'updated_at']
            ])
            ->assertJson(['data' => $customerData]);

        $this->assertDatabaseHas('customers', $customerData);
    }

    public function test_can_update_customer(): void
    {
        $customer = Customers::factory()->create();
        $updateData = [
            'nombre' => 'Updated Name',
            'correo' => 'updated_email@example.com',
            'telefono' => '555-123-9999',
            'direccion' => 'Updated Address',
        ];

        $this->putJson(route('customers.update', $customer), $updateData)
            ->assertStatus(200)
            ->assertJson(['data' => array_merge(['id' => $customer->id], $updateData)]);

        $this->assertDatabaseHas('customers', ['id' => $customer->id] + $updateData);
    }

    public function test_updating_non_existent_customer_returns_404(): void
    {
        $this->putJson('/api/customers/999', [
            'nombre' => 'Test Name',
            'correo' => 'test@example.com',
            'telefono' => '555-123-4567',
            'direccion' => 'Test Address',
        ])
            ->assertStatus(404);
    }

    public function test_can_delete_customer(): void
    {
        $customer = Customers::factory()->create();

        $this->deleteJson(route('customers.destroy', $customer))
            ->assertStatus(200)
            ->assertJson(['message' => 'Customer deleted successfully']);

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }

    public function test_deleting_non_existent_customer_returns_404(): void
    {
        $this->deleteJson('/api/customers/999')
            ->assertStatus(404);
    }
}
