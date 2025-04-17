<?php

namespace App\ReservationManagement\Customers\Domain\Exceptions;

class CustomerNotFoundException extends CustomerException
{
    protected $httpCode = 404;

    public function __construct($message = "Customer not found")
    {
        parent::__construct($message);
    }
}
