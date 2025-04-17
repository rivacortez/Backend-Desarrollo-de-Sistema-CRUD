<?php

namespace App\ReservationManagement\Tables\domain\model\queries;

class GetAllTablesByIdQuery
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
