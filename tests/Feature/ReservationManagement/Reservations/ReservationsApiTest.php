<?php

namespace Tests\Feature\ReservationManagement\Reservations;

use App\ReservationManagement\Customers\domain\model\aggregates\Customers;
use App\ReservationManagement\Tables\domain\model\aggregates\Tables;
use App\ReservationManagement\Reservations\domain\model\aggregates\Reservations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationsApiTest extends TestCase
{
    use RefreshDatabase;

    private Customers $customer;
    private Tables $table;
    private array $reservationData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customers::factory()->create();
        $this->table = Tables::factory()->create();

        $this->reservationData = [
            'fecha'              => '2023-08-15',
            'hora'               => '19:30:00',
            'numero_de_personas' => 4,
            'comensal_id'        => $this->customer->id,
            'mesa_id'            => $this->table->id,
        ];
    }

    public function test_can_get_all_reservations(): void
    {
        Reservations::factory()
            ->count(3)
            ->create([
                'comensal_id' => $this->customer->id,
                'mesa_id'     => $this->table->id,
            ]);

        $this->getJson(route('reservations.index'))
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_single_reservation(): void
    {
        $reservation = Reservations::factory()->create([
            'comensal_id' => $this->customer->id,
            'mesa_id'     => $this->table->id,
        ]);

        $this->getJson(route('reservations.show', $reservation))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'                  => $reservation->id,
                    'fecha'               => $reservation->fecha,
                    'hora'                => $reservation->hora,
                    'numero_de_personas'  => $reservation->numero_de_personas,
                    'comensal_id'         => $this->customer->id,
                    'mesa_id'             => $this->table->id,
                ],
            ]);
    }

    public function test_getting_non_existent_reservation_returns_404(): void
    {
        $this->getJson('/api/reservations/999')
            ->assertStatus(404);
    }

    public function test_can_create_reservation(): void
    {
        $this->postJson(route('reservations.store'), $this->reservationData)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'fecha'              => $this->reservationData['fecha'],
                    'hora'               => $this->reservationData['hora'],
                    'numero_de_personas' => $this->reservationData['numero_de_personas'],
                    'comensal_id'        => $this->customer->id,
                    'mesa_id'            => $this->table->id,
                ],
            ]);

        $this->assertDatabaseHas('reservations', $this->reservationData);
    }

    public function test_can_update_reservation(): void
    {
        $reservation = Reservations::factory()->create([
            'comensal_id' => $this->customer->id,
            'mesa_id'     => $this->table->id,
        ]);

        $updated = [
            'fecha'              => '2023-09-20',
            'hora'               => '20:45:00',
            'numero_de_personas' => 6,
            'comensal_id'        => $this->customer->id,
            'mesa_id'            => $this->table->id,
        ];

        $this->putJson(route('reservations.update', $reservation), $updated)
            ->assertStatus(200)
            ->assertJson(['data' => array_merge(['id' => $reservation->id], $updated)]);

        $this->assertDatabaseHas('reservations', ['id' => $reservation->id] + $updated);
    }

    public function test_can_delete_reservation(): void
    {
        $reservation = Reservations::factory()->create([
            'comensal_id' => $this->customer->id,
            'mesa_id'     => $this->table->id,
        ]);

        $this->deleteJson(route('reservations.destroy', $reservation))
            ->assertStatus(200)
            ->assertJson(['message' => 'Reservation deleted successfully']);

        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }

    public function test_validation_fails_with_invalid_data(): void
    {
        $this->postJson(route('reservations.store'), ['fecha' => '2023-08-15'])
            ->assertStatus(422);
    }

    public function test_validation_fails_with_nonexistent_foreign_keys(): void
    {
        $invalid = [
            'fecha'              => '2023-08-15',
            'hora'               => '19:30:00',
            'numero_de_personas' => 4,
            'comensal_id'        => 9999,
            'mesa_id'            => 9999,
        ];

        $this->postJson(route('reservations.store'), $invalid)
            ->assertStatus(422);
    }
}
