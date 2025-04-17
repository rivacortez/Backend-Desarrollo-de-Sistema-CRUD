<?php

namespace App\ReservationManagement\Customers\Domain\Exceptions;

class CustomerUpdateException extends CustomerException
{
    public function __construct($message = "Error updating customer")
    {
        parent::__construct($message);
    }
}
