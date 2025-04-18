<?php

namespace App\ReservationManagement\Reservations\domain\exeptions;

class ReservationNotFoundException extends ReservationsException
{
    protected $httpCode = 404;

    public function __construct($message = "Customer not found")
    {
        parent::__construct($message);
    }
}
