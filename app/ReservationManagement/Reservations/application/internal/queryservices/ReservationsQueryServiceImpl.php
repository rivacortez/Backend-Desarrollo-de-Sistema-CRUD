<?php

namespace App\ReservationManagement\Reservations\application\internal\queryservices;

use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsByIdQuery;
use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsQuery;
use App\ReservationManagement\Reservations\domain\services\ReservationsQueryService;
use App\ReservationManagement\Reservations\infrastructure\persistence\ReservationsRepository;

class ReservationsQueryServiceImpl implements ReservationsQueryService
{
    private $repository;

    public function __construct(ReservationsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetAllReservationsQuery $query)
    {
        return $this->repository->getAll();
    }

    public function executeById(GetAllReservationsByIdQuery $query)
    {
        return $this->repository->getById($query->id);
    }
}
