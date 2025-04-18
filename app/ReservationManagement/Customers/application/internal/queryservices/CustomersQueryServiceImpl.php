<?php

namespace App\ReservationManagement\Customers\application\internal\queryservices;

use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersByIdQuery;
use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersQuery;
use App\ReservationManagement\Customers\Domain\Services\CustomersQueryService;
use App\ReservationManagement\Customers\Infrastructure\Persistence\CustomersRepository;

/**
 * Implementation of the CustomersQueryService interface
 *
 * This service is responsible for retrieving customer data
 * through query operations. It acts as an intermediary between
 * the controller and the repository.
 */
class CustomersQueryServiceImpl implements CustomersQueryService
{
    /**
     * The customers repository instance
     *
     * @var CustomersRepository
     */
    private $repository;

    /**
     * Create a new CustomersQueryServiceImpl instance
     *
     * @param CustomersRepository $repository The repository for customer data access
     */
    public function __construct(CustomersRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Execute a query to retrieve all customers
     *
     * @param GetAllCustomersQuery $query The query object
     * @return mixed Collection of all customers
     */
    public function execute(GetAllCustomersQuery $query)
    {
        return $this->repository->getAll();
    }

    /**
     * Execute a query to retrieve a specific customer by ID
     *
     * @param GetAllCustomersByIdQuery $query The query object containing the customer ID
     * @return mixed The customer with the specified ID
     * @throws CustomersNotFoundException If the customer is not found
     */
    public function executeById(GetAllCustomersByIdQuery $query)
    {
        return $this->repository->getById($query->id);
    }
}
