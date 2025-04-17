<?php

namespace App\ReservationManagement\Tables\domain\exeptions;


class TablesNotFoundException extends TablesException
{
    protected $httpCode = 404;

    public function __construct($message = "Table not found")
    {
        parent::__construct($message);
    }
}
