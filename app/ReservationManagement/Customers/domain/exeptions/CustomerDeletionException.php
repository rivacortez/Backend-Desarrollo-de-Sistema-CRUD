<?php

namespace App\ReservationManagement\Customers\Domain\Exceptions;

class CustomerDeletionException extends CustomerException
{
    public function __construct($message = "Error deleting customer")
    {
        parent::__construct($message);
    }
}
