<?php

namespace App\ReservationManagement\Customers\domain\exeptions;

use App\ReservationManagement\Customers\domain\exeptions;

class CustomersCreationException extends CustomerException
{
    public function __construct($message = "Error creating customer")
    {
        parent::__construct($message);
    }
}
