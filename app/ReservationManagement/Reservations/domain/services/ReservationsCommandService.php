<?php

namespace App\ReservationManagement\Reservations\domain\services;

use App\ReservationManagement\Reservations\domain\model\commands\ReservationsCommand;

interface ReservationsCommandService
{
    public function handle(ReservationsCommand $command);
    public function delete($id);
}
