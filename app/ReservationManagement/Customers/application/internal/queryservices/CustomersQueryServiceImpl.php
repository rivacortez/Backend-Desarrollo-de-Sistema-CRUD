<?php

namespace App\ReservationManagement\Customers\application\internal\queryservices;

use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersByIdQuery;
use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersQuery;
use App\ReservationManagement\Customers\Domain\Services\CustomersQueryService;
use App\ReservationManagement\Customers\Infrastructure\Persistence\CustomersRepository;



class CustomersQueryServiceImpl implements CustomersQueryService
{
    private $repository;

    public function __construct(CustomersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetAllCustomersQuery $query)
    {
        return $this->repository->getAll();
    }

    public function executeById(GetAllCustomersByIdQuery $query)
    {
        return $this->repository->getById($query->id);
    }
}
