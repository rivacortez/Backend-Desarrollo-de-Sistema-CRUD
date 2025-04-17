<?php

namespace App\ReservationManagement\Tables\domain\exeptions;

class TablesCreationException extends TablesException
{
    public function __construct($message = "Error creating table")
    {
        parent::__construct($message);
    }
}
