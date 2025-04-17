<?php

namespace App\ReservationManagement\Customers\Domain\Exceptions;

use Exception;

class CustomerException extends Exception
{
    protected $httpCode = 422;

    public function getHttpCode()
    {
        return $this->httpCode;
    }
}
