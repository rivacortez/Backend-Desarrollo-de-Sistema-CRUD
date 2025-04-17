<?php

namespace App\ReservationManagement\Tables\domain\exeptions;

use Exception;

class TablesException extends Exception
{
    protected $httpCode = 422;

    public function getHttpCode()
    {
        return $this->httpCode;
    }
}
