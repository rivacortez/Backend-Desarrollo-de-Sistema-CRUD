<?php

namespace App\ReservationManagement\Tables\domain\services;

use App\ReservationManagement\Tables\Domain\Model\Commands\TablesCommand;

interface TablesCommandService
{
    public function handle(TablesCommand $command);
    public function delete($id);
}
