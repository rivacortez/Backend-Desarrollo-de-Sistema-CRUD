<?php

namespace Tests\Feature\ReservationManagement\Tables;

use App\ReservationManagement\Tables\domain\model\aggregates\Tables;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TablesApiTest extends TestCase
{
    use RefreshDatabase;

    private array $tableData = [
        'numero_mesa' => 'A-15',
        'capacidad'   => 4,
        'ubicacion'   => 'Terraza Sur',
    ];

    public function test_can_get_all_tables(): void
    {
        Tables::factory()->count(3)->create();

        $this->getJson(route('tables.index'))
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_get_single_table(): void
    {
        $table = Tables::factory()->create();

        $this->getJson(route('tables.show', $table))
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'           => $table->id,
                    'numero_mesa'  => $table->numero_mesa,
                    'capacidad'    => $table->capacidad,
                    'ubicacion'    => $table->ubicacion,
                ],
            ]);
    }

    public function test_getting_non_existent_table_returns_404(): void
    {
        $this->getJson('/api/tables/999')
            ->assertStatus(404);
    }

    public function test_can_create_table(): void
    {
        $this->postJson(route('tables.store'), $this->tableData)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'numero_mesa', 'capacidad', 'ubicacion', 'created_at', 'updated_at'],
            ])
            ->assertJson(['data' => $this->tableData]);

        $this->assertDatabaseHas('tables', $this->tableData);
    }

    public function test_can_update_table(): void
    {
        $table = Tables::factory()->create();
        $updatedData = [
            'numero_mesa' => 'B-20',
            'capacidad'   => 6,
            'ubicacion'   => 'Interior VIP',
        ];

        $this->putJson(route('tables.update', $table), $updatedData)
            ->assertStatus(200)
            ->assertJson(['data' => array_merge(['id' => $table->id], $updatedData)]);

        $this->assertDatabaseHas('tables', ['id' => $table->id] + $updatedData);
    }

    public function test_can_delete_table(): void
    {
        $table = Tables::factory()->create();

        $this->deleteJson(route('tables.destroy', $table))
            ->assertStatus(200)
            ->assertJson(['message' => 'Table deleted successfully']);

        $this->assertDatabaseMissing('tables', ['id' => $table->id]);
    }

    public function test_validation_fails_with_incomplete_data(): void
    {
        $this->postJson(route('tables.store'), ['numero_mesa' => 'A-10'])
            ->assertStatus(422);
    }
}
