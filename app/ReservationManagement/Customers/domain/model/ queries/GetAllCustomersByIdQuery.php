<?php

namespace App\ReservationManagement\Customers\Domain\Model\Queries;

class GetAllCustomersByIdQuery
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
