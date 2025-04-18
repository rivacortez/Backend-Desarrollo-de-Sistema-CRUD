<?php

namespace App\ReservationManagement\Reservations\domain\exeptions;

use Exception;

class ReservationsException extends Exception
{
    protected $httpCode = 422;

    public function getHttpCode()
    {
        return $this->httpCode;
    }
}
