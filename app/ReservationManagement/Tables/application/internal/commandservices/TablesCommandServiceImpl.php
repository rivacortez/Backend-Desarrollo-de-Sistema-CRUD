<?php

namespace App\ReservationManagement\Tables\application\internal\commandservices;

use App\ReservationManagement\Tables\Domain\Services\TablesCommandService;
use App\ReservationManagement\Tables\Domain\Model\Commands\TablesCommand;
use App\ReservationManagement\Tables\infrastructure\persistence\TablesRepository;
use Illuminate\Support\Facades\Validator;

/**
 * Tables Command Service Implementation
 *
 * This class implements the application layer service responsible for handling table commands
 * within the Reservation Management bounded context. It serves as a mediator between the interface layer
 * (controllers) and the domain/infrastructure layers, following the Command pattern and Hexagonal Architecture.
 *
 * The service encapsulates all command processing logic for restaurant tables:
 * - Creating new tables
 * - Updating existing table information
 * - Removing table records
 *
 * Each operation delegates to the appropriate repository method after preparing the necessary data,
 * maintaining separation of concerns between application flow control and persistence operations.
 *
 * This implementation follows the Dependency Inversion Principle by depending on the repository
 * abstraction rather than concrete implementations.
 */
class TablesCommandServiceImpl implements TablesCommandService
{
    /**
     * The repository instance responsible for table persistence operations
     *
     * @var TablesRepository
     */
    private $repository;

    /**
     * Constructor with dependency injection for the repository
     *
     * @param TablesRepository $repository The repository for table persistence operations
     */
    public function __construct(TablesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle a table command for creation or update operations
     *
     * Processes the command by extracting table data and determining whether
     * to create a new table or update an existing one based on the presence of an ID.
     * The actual persistence operation is delegated to the repository.
     *
     * @param TablesCommand $command The command containing table data
     * @return mixed The newly created or updated table entity
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableCreationException When validation fails or errors occur during creation
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableUpdateException When validation fails or errors occur during update
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableNotFoundException When the specified table doesn't exist for updates
     */
    public function handle(TablesCommand $command)
    {
        $data = [
            'numero_mesa' => $command->numero_mesa,
            'capacidad' => $command->capacidad,
            'ubicacion' => $command->ubicacion,
        ];

        if ($command->id) {
            return $this->repository->update($command->id, $data);
        } else {
            return $this->repository->store($data);
        }
    }

    /**
     * Delete a table record from the system
     *
     * Removes an existing table based on its unique identifier.
     * The actual deletion operation is delegated to the repository.
     *
     * @param int $id The unique identifier of the table to delete
     * @return bool True if deletion was successful
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableNotFoundException When the specified table doesn't exist
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableDeletionException When database errors occur during deletion
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
