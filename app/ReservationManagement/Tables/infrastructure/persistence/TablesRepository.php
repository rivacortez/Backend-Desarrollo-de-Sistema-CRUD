<?php

namespace App\ReservationManagement\Tables\infrastructure\persistence;

use App\ReservationManagement\Tables\domain\exeptions\TablesCreationException;
use App\ReservationManagement\Tables\domain\exeptions\TablesDeletionException;
use App\ReservationManagement\Tables\domain\exeptions\TablesNotFoundException;
use App\ReservationManagement\Tables\domain\exeptions\TablesUpdateException;
use App\ReservationManagement\Tables\Domain\Model\Aggregates\Tables;
use Illuminate\Support\Facades\Validator;

/**
 * Tables Repository
 *
 * This class implements the repository pattern for the Tables aggregate root within
 * the Reservation Management bounded context. It serves as the primary infrastructure layer
 * component responsible for persisting and retrieving restaurant table data.
 *
 * The repository isolates the domain layer from the underlying database implementation,
 * following the Hexagonal Architecture principles. It handles all CRUD operations while
 * enforcing domain validation rules and ensuring proper exception handling for various
 * failure scenarios.
 *
 * All operations include appropriate error handling to maintain the system's reliability
 * and provide meaningful feedback when operations cannot be completed as requested.
 *
 * This implementation leverages Laravel's Eloquent ORM for data persistence while maintaining
 * a clean separation from the domain model through structured exception handling.
 */
class TablesRepository
{
    /**
     * Retrieve all tables from the system
     *
     * Fetches all table records from the database without any filtering,
     * providing a complete view of all available tables in the restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of all table entities
     */
    public function getAll()
    {
        return Tables::all();
    }

    /**
     * Retrieve a specific table by its unique identifier
     *
     * Fetches a single table record by ID. Throws an exception
     * if the requested table cannot be found.
     *
     * @param int $id The unique identifier of the table to retrieve
     * @return Tables The found table entity
     * @throws TablesNotFoundException When no table exists with the provided ID
     */
    public function getById($id)
    {
        $table = Tables::find($id);

        if (!$table) {
            throw new TablesNotFoundException("Table with ID {$id} not found");
        }

        return $table;
    }

    /**
     * Create a new table record
     *
     * Validates the provided data against domain rules and creates a new
     * table record in the database. Throws appropriate exceptions
     * for validation failures or database errors.
     *
     * @param array $data The table data to be stored (numero_mesa, capacidad, ubicacion)
     * @return Tables The newly created table entity
     * @throws TablesCreationException When validation fails or database errors occur
     */
    public function store(array $data)
    {
        $validator = Validator::make($data, (new Tables())->rules());

        if ($validator->fails()) {
            throw new TablesCreationException($validator->errors()->first());
        }

        try {
            return Tables::create($data);
        } catch (\Exception $e) {
            throw new TablesCreationException("Failed to create table: " . $e->getMessage());
        }
    }

    /**
     * Update an existing table record
     *
     * Locates a table by ID, validates the updated data against domain rules,
     * and persists the changes to the database. Throws appropriate exceptions
     * when the table cannot be found, validation fails, or database errors occur.
     *
     * @param int $id The unique identifier of the table to update
     * @param array $data The new table data to be applied
     * @return Tables The updated table entity
     * @throws TablesNotFoundException When the table cannot be found
     * @throws TablesUpdateException When validation fails or database errors occur
     */
    public function update($id, array $data)
    {
        $table = Tables::find($id);

        if (!$table) {
            throw new TablesNotFoundException("Table with ID {$id} not found");
        }

        $validator = Validator::make($data, $table->rules());

        if ($validator->fails()) {
            throw new TablesUpdateException($validator->errors()->first());
        }

        try {
            $table->update($data);
            return $table;
        } catch (\Exception $e) {
            throw new TablesUpdateException("Failed to update table: " . $e->getMessage());
        }
    }

    /**
     * Delete a table record from the system
     *
     * Locates a table by ID and removes it from the database.
     * Throws appropriate exceptions when the table cannot be found
     * or when database errors prevent successful deletion.
     *
     * @param int $id The unique identifier of the table to delete
     * @return bool True if deletion was successful
     * @throws TablesNotFoundException When the table cannot be found
     * @throws TablesDeletionException When database errors prevent deletion
     */
    public function delete($id)
    {
        $table = Tables::find($id);

        if (!$table) {
            throw new TablesNotFoundException("Table with ID {$id} not found");
        }

        try {
            return $table->delete();
        } catch (\Exception $e) {
            throw new TablesDeletionException("Failed to delete table: " . $e->getMessage());
        }
    }
}
