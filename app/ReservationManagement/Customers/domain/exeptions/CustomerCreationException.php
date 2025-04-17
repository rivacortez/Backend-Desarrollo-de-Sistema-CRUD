<?php

namespace App\ReservationManagement\Customers\Domain\Exceptions;

class CustomerCreationException extends CustomerException
{
    public function __construct($message = "Error creating customer")
    {
        parent::__construct($message);
    }
}
