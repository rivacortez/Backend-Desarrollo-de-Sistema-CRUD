<?php

namespace App\ReservationManagement\Customers\domain\services;

use App\ReservationManagement\Customers\Domain\Model\Commands\CustomerCommand;

interface CustomersCommandService
{
    public function handle(CustomerCommand $command);
    public function delete($id);
}
