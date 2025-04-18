<?php

namespace App\ReservationManagement\Reservations\domain\model\queries;

class GetAllReservationsByIdQuery
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
