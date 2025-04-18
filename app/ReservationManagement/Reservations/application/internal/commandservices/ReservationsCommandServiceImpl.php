<?php

namespace App\ReservationManagement\Reservations\application\internal\commandservices;

use App\ReservationManagement\Reservations\domain\services\ReservationsCommandService;
use App\ReservationManagement\Reservations\domain\model\commands\ReservationsCommand;
use App\ReservationManagement\Reservations\infrastructure\persistence\ReservationsRepository;

class ReservationsCommandServiceImpl implements ReservationsCommandService
{
    private $repository;

    public function __construct(ReservationsRepository $repository)
    {
        $this->repository = $repository;
    }

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

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
