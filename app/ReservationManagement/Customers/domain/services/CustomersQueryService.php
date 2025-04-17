<?php

namespace App\ReservationManagement\Customers\domain\services;

use App\ReservationManagement\Customers\Domain\Model\Queries\GetAllCustomersQuery;
use App\ReservationManagement\Customers\Domain\Model\Queries\GetAllCustomersByIdQuery;

interface CustomersQueryService
{
    public function execute(GetAllCustomersQuery $query);
    public function executeById(GetAllCustomersByIdQuery $query);
}
