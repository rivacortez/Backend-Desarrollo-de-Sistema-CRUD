<?php

namespace App\ReservationManagement\Tables\domain\services;

use App\ReservationManagement\Tables\Domain\Model\Commands\TablesCommand;

/**
 * Tables Command Service Interface
 *
 * This interface defines the contract for handling table commands within the
 * Reservation Management bounded context. It serves as a primary port in the hexagonal
 * architecture pattern, connecting the application layer to the domain layer.
 *
 * The Command Service follows the Command pattern to encapsulate operations that modify
 * the state of table entities, providing a clear separation between query and command
 * operations (CQRS principle).
 *
 * Implementations of this interface are responsible for:
 * - Processing table creation commands
 * - Processing table update commands
 * - Handling table deletion operations
 *
 * This interface belongs to the domain layer and helps maintain the integrity of the
 * domain model by defining operations that can be performed on table entities.
 */
interface TablesCommandService
{
    /**
     * Handle a table command for creation or update operations
     *
     * Process the table command, determining whether to create a new table
     * or update an existing one based on the provided command data. The implementation
     * should validate the command data and delegate to the appropriate domain operations.
     *
     * @param TablesCommand $command The command containing table operation data
     * @return mixed The newly created or updated table entity
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableCreationException When validation fails or errors occur during creation
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableUpdateException When validation fails or errors occur during update
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableNotFoundException When the specified table doesn't exist for updates
     */
    public function handle(TablesCommand $command);

    /**
     * Delete a table record from the system
     *
     * Removes an existing table based on its unique identifier.
     * The implementation should verify the table's existence before deletion.
     *
     * @param int $id The unique identifier of the table to delete
     * @return bool True if deletion was successful
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableNotFoundException When the specified table doesn't exist
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableDeletionException When errors occur during deletion
     */
    public function delete($id);
}
