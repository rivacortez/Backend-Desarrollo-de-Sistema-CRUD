<?php

namespace App\ReservationManagement\Customers\domain\services;

use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersByIdQuery;
use App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersQuery;

/**
 * Customers Query Service Interface
 *
 * This interface defines the contract for handling query operations within the Customers
 * bounded context of the Reservation Management system. It follows the Command Query
 * Responsibility Segregation (CQRS) pattern, focusing on the query (read) side of operations.
 *
 * The query service is responsible for retrieving customer data without modifying the system state.
 * It processes immutable query objects that represent the intent to retrieve specific customer
 * information, providing a clear separation between read and write operations.
 *
 * Implementation classes should handle the retrieval of customer data from the underlying
 * persistence mechanism, transforming it as needed for the consuming application layers.
 *
 * @see \App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersQuery
 * @see \App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersByIdQuery
 * @see \App\ReservationManagement\Customers\domain\model\aggregates\Customers
 * @see \App\ReservationManagement\Customers\domain\services\CustomersCommandService
 */
interface CustomersQueryService
{
    /**
     * Execute a query to retrieve all customers
     *
     * Processes the query to retrieve the complete collection of customer entities.
     * This method handles bulk retrieval operations without filtering criteria.
     *
     * @param GetAllCustomersQuery $query The query object requesting all customers
     * @return mixed Collection of all customer entities
     * @throws \App\ReservationManagement\Customers\domain\exeptions\CustomersNotFoundException When customer data cannot be retrieved
     */
    public function execute(GetAllCustomersQuery $query);

    /**
     * Execute a query to retrieve a specific customer by ID
     *
     * Processes the query to retrieve a single customer entity based on its unique identifier.
     * This method handles targeted retrieval operations with specific filtering criteria.
     *
     * @param GetAllCustomersByIdQuery $query The query object containing the customer ID
     * @return mixed The requested customer entity
     * @throws \App\ReservationManagement\Customers\domain\exeptions\CustomersNotFoundException When the requested customer doesn't exist
     */
    public function executeById(GetAllCustomersByIdQuery $query);
}
