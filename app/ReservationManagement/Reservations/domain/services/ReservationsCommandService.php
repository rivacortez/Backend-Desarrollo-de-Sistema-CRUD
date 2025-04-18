<?php

namespace App\ReservationManagement\Reservations\domain\services;

use App\ReservationManagement\Reservations\domain\model\commands\ReservationsCommand;

/**
 * Reservations Command Service Interface
 *
 * This interface defines the contract for handling reservation commands within the
 * Reservation Management bounded context. It serves as a primary port in the hexagonal
 * architecture pattern, connecting the application layer to the domain layer.
 *
 * The Command Service follows the Command pattern to encapsulate operations that modify
 * the state of reservation entities, providing a clear separation between query and command
 * operations (CQRS principle).
 *
 * Implementations of this interface are responsible for:
 * - Processing reservation creation commands
 * - Processing reservation update commands
 * - Handling reservation deletion operations
 *
 * This interface belongs to the domain layer and helps maintain the integrity of the
 * domain model by defining operations that can be performed on reservation entities.
 */
interface ReservationsCommandService
{
    /**
     * Handle a reservation command for creation or update operations
     *
     * Process the reservation command, determining whether to create a new reservation
     * or update an existing one based on the provided command data. The implementation
     * should validate the command data and delegate to the appropriate domain operations.
     *
     * @param ReservationsCommand $command The command containing reservation operation data
     * @return mixed The newly created or updated reservation entity
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationCreationException When validation fails or errors occur during creation
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationUpdateException When validation fails or errors occur during update
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException When the specified reservation doesn't exist for updates
     */
    public function handle(ReservationsCommand $command);

    /**
     * Delete a reservation record from the system
     *
     * Removes an existing reservation based on its unique identifier.
     * The implementation should verify the reservation's existence before deletion.
     *
     * @param int $id The unique identifier of the reservation to delete
     * @return bool True if deletion was successful
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException When the specified reservation doesn't exist
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationDeletionException When errors occur during deletion
     */
    public function delete($id);
}
