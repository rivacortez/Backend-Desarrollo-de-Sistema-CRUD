<?php

namespace App\ReservationManagement\Reservations\domain\exeptions;


class ReservationUpdateException extends ReservationsException
{
    public function __construct($message = "Error updating customer")
    {
        parent::__construct($message);
    }
}
