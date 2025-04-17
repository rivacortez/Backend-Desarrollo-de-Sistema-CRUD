<?php

namespace App\ReservationManagement\Customers\domain\exeptions;

use App\ReservationManagement\Customers\domain\exeptions;

class CustomerCreationException extends CustomerException
{
    public function __construct($message = "Error creating customer")
    {
        parent::__construct($message);
    }
}
