<?php

namespace App\ReservationManagement\Customers\domain\model\queries;

class GetAllTablesByIdQuery
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
