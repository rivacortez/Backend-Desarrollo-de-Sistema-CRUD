<?php

namespace App\ReservationManagement\Reservations\domain\services;

use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsQuery;
use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsByIdQuery;

interface ReservationsQueryService
{
    public function execute(GetAllReservationsQuery $query);
    public function executeById(GetAllReservationsByIdQuery $query);
}
