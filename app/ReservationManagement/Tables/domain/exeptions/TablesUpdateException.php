<?php

namespace App\ReservationManagement\Tables\domain\exeptions;

use App\ReservationManagement\Tables\domain\exeptions\TablesException;

class TablesUpdateException extends TablesException
{
    public function __construct($message = "Error updating table")
    {
        parent::__construct($message);
    }
}
