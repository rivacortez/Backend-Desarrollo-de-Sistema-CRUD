<?php

namespace App\ReservationManagement\Customers\domain\exeptions;

class CustomersNotFoundException extends CustomerException
{
    protected $httpCode = 404;

    public function __construct($message = "Customer not found")
    {
        parent::__construct($message);
    }
}
