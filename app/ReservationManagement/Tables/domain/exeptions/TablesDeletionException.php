<?php

namespace App\ReservationManagement\Tables\domain\exeptions;


class TablesDeletionException extends TablesException
{
    public function __construct($message = "Error deleting table")
    {
        parent::__construct($message);
    }
}
