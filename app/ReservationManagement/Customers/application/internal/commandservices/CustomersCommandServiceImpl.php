<?php

namespace App\ReservationManagement\Customers\application\internal\commandservices;

use App\ReservationManagement\Customers\Domain\Services\CustomersCommandService;
use App\ReservationManagement\Customers\Domain\Model\Commands\CustomerCommand;
use App\ReservationManagement\Customers\Infrastructure\Persistence\CustomersRepository;
use Illuminate\Support\Facades\Validator;

/**
 * Implementation of the CustomersCommandService interface.
 *
 * This service handles command operations for customers such as
 * creating, updating, and deleting customer records.
 */
class CustomersCommandServiceImpl implements CustomersCommandService
{
    /**
     * The customers repository instance.
     *
     * @var CustomersRepository
     */
    private $repository;

    /**
     * Create a new CustomersCommandServiceImpl instance.
     *
     * @param CustomersRepository $repository The customers repository
     */
    public function __construct(CustomersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle a customer command to create or update a customer.
     *
     * @param CustomerCommand $command The customer command object containing customer data
     * @return mixed The created or updated customer entity
     */
    public function handle(CustomerCommand $command)
    {
        $data = [
            'nombre' => $command->nombre,
            'correo' => $command->correo,
            'telefono' => $command->telefono,
            'direccion' => $command->direccion,
        ];

        if ($command->id) {
            return $this->repository->update($command->id, $data);
        } else {
            return $this->repository->store($data);
        }
    }

    /**
     * Delete a customer by ID.
     *
     * @param int|string $id The ID of the customer to delete
     * @return mixed The result of the delete operation
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
