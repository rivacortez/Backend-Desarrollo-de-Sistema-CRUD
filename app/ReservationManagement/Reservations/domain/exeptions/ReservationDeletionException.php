<?php

namespace App\ReservationManagement\Reservations\domain\exeptions;

use App\ReservationManagement\Customers\domain\exeptions;

class ReservationDeletionException extends ReservationsException
{
    public function __construct($message = "Error deleting customer")
    {
        parent::__construct($message);
    }
}
