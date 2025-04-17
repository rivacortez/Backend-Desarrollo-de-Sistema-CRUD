<?php

namespace App\ReservationManagement\Tables\application\internal\commandservices;

use App\ReservationManagement\Tables\Domain\Services\TablesCommandService;
use App\ReservationManagement\Tables\Domain\Model\Commands\TablesCommand;
use Illuminate\Support\Facades\Validator;

class TablesCommandServiceImpl implements TablesCommandService
{
    private $repository;

    public function __construct(TablesRepository $repository)
    {
        $this->repository = $repository;
    }

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

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
