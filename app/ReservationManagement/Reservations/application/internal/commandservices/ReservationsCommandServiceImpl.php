<?php

namespace App\ReservationManagement\Reservations\application\internal\commandservices;

use App\ReservationManagement\Reservations\domain\services\ReservationsCommandService;
use App\ReservationManagement\Reservations\domain\model\commands\ReservationsCommand;
use App\ReservationManagement\Reservations\infrastructure\persistence\ReservationsRepository;

/**
 * Reservations Command Service Implementation
 *
 * This class implements the application layer service responsible for handling reservation commands
 * within the Reservation Management bounded context. It serves as a mediator between the interface layer
 * (controllers) and the domain/infrastructure layers, following the Command pattern and Hexagonal Architecture.
 *
 * The service encapsulates all command processing logic for reservations:
 * - Creating new reservations
 * - Updating existing reservation information
 * - Removing reservation records
 *
 * Each operation delegates to the appropriate repository method after preparing the necessary data,
 * maintaining separation of concerns between application flow control and persistence operations.
 *
 * This implementation follows the Dependency Inversion Principle by depending on the repository
 * abstraction rather than concrete implementations.
 */
class ReservationsCommandServiceImpl implements ReservationsCommandService
{
    /**
     * The repository instance responsible for reservation persistence operations
     *
     * @var ReservationsRepository
     */
    private $repository;

    /**
     * Constructor with dependency injection for the repository
     *
     * @param ReservationsRepository $repository The repository for reservation persistence operations
     */
    public function __construct(ReservationsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle a reservation command for creation or update operations
     *
     * Processes the command by extracting reservation data and determining whether
     * to create a new reservation or update an existing one based on the presence of an ID.
     * The actual persistence operation is delegated to the repository.
     *
     * @param ReservationsCommand $command The command containing reservation data
     * @return mixed The newly created or updated reservation entity
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationCreationException When validation fails or errors occur during creation
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationUpdateException When validation fails or errors occur during update
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException When the specified reservation doesn't exist for updates
     */
    public function handle(ReservationsCommand $command)
    {
        $data = [
            'fecha' => $command->fecha,
            'hora' => $command->hora,
            'numero_de_personas' => $command->numero_de_personas,
            'comensal_id' => $command->comensal_id,
            'mesa_id' => $command->mesa_id,
        ];

        if ($command->id) {
            return $this->repository->update($command->id, $data);
        } else {
            return $this->repository->store($data);
        }
    }

    /**
     * Delete a reservation record from the system
     *
     * Removes an existing reservation based on its unique identifier.
     * The actual deletion operation is delegated to the repository.
     *
     * @param int $id The unique identifier of the reservation to delete
     * @return bool True if deletion was successful
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException When the specified reservation doesn't exist
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationDeletionException When database errors occur during deletion
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
