<?php

namespace App\ReservationManagement\Customers\domain\model\queries;

class GetAllCustomersByIdQuery
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
