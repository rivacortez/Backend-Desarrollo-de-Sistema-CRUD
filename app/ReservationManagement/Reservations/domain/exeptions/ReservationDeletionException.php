<?php

namespace App\ReservationManagement\Reservations\domain\exeptions;

use App\ReservationManagement\Customers\domain\exeptions;

class ReservationDeletionException extends ReservationsException
{
    protected $httpCode = 500;

    public function __construct($message = "Error deleting reservation")
    {
        parent::__construct($message);
    }
}
