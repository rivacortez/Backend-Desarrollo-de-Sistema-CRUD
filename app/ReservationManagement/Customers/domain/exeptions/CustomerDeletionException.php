<?php

namespace App\ReservationManagement\Customers\domain\exeptions;

use App\ReservationManagement\Customers\domain\exeptions;

class CustomerDeletionException extends CustomerException
{
    public function __construct($message = "Error deleting customer")
    {
        parent::__construct($message);
    }
}
