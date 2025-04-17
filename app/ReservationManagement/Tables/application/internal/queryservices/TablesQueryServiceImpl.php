<?php

namespace App\ReservationManagement\Tables\application\internal\queryservices;

use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesByIdQuery;
use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesQuery;
use App\ReservationManagement\Tables\Domain\Services\TablesQueryService;
use App\ReservationManagement\Tables\infrastructure\persistence\TablesRepository;

class TablesQueryServiceImpl implements TablesQueryService
{
    private $repository;
    public function __construct(TablesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetAllTablesQuery $query)
    {
        return $this->repository->getAll();
    }

    public function executeById(GetAllTablesByIdQuery $query)
    {
        return $this->repository->getById($query->id);
    }
}
