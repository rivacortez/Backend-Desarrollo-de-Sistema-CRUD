<?php

namespace App\ReservationManagement\Tables\domain\services;

use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesQuery;
use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesByIdQuery;

interface TablesQueryService
{
    public function execute(GetAllTablesQuery $query);
    public function executeById(GetAllTablesByIdQuery $query);
}
