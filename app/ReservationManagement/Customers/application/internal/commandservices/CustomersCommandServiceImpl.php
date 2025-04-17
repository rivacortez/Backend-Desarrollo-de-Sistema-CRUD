<?php


namespace App\ReservationManagement\Customers\application\internal\commandservices;

use App\ReservationManagement\Customers\Domain\Services\CustomersCommandService;
use App\ReservationManagement\Customers\Domain\Model\Commands\CustomerCommand;
use App\ReservationManagement\Customers\Infrastructure\Persistence\CustomersRepository;
use Illuminate\Support\Facades\Validator;

class CustomersCommandServiceImpl implements CustomersCommandService
{
    private $repository;

    public function __construct(CustomersRepository $repository)
    {
        $this->repository = $repository;
    }

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

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
