<?php

namespace App\ReservationManagement\Customers\domain\services;

use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersByIdQuery;
use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersQuery;

interface CustomersQueryService
{
    public function execute(GetAllCustomersQuery $query);
    public function executeById(GetAllCustomersByIdQuery $query);
}
