<?php

namespace App\ReservationManagement\Customers\Domain\Services;

use App\ReservationManagement\Customers\Domain\Model\Commands\CustomerCommand;

interface CustomersCommandService
{
    public function handle(CustomerCommand $command);
    public function delete($id);
}
