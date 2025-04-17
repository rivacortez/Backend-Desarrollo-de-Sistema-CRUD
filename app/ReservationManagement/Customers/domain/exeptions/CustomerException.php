<?php

namespace App\ReservationManagement\Customers\domain\exeptions;

use Exception;

class CustomerException extends Exception
{
    protected $httpCode = 422;

    public function getHttpCode()
    {
        return $this->httpCode;
    }
}
