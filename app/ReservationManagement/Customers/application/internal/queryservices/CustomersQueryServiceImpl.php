<?php

namespace App\ReservationManagement\Customers\Application\Internal\QueryServices;

use App\ReservationManagement\Customers\Domain\Services\CustomersQueryService;
use App\ReservationManagement\Customers\Domain\Model\Queries\GetAllCustomersQuery;
use App\ReservationManagement\Customers\Domain\Model\Queries\GetAllCustomersByIdQuery;
use App\ReservationManagement\Customers\Infrastructure\Persistence\CustomersRepository;


//TODO:implement CustomerRepository

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
