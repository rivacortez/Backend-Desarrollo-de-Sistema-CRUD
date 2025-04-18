<?php

namespace App\ReservationManagement\Reservations\domain\exeptions;

use App\ReservationManagement\Customers\domain\exeptions;

class ReservationCreationException extends ReservationsException
{
    public function __construct($message = "Error creating customer")
    {
        parent::__construct($message);
    }
}
