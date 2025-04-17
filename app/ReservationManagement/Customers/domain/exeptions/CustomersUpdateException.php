<?php

namespace App\ReservationManagement\Customers\domain\exeptions;

class CustomersUpdateException extends CustomerException
{
    public function __construct($message = "Error updating customer")
    {
        parent::__construct($message);
    }
}
