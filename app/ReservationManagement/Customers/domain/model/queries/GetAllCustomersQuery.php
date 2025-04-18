<?php

namespace App\ReservationManagement\Customers\domain\model\queries;

/**
 * Customer Collection Query Value Object
 *
 * This query encapsulates the request to retrieve all customers within the Customers bounded context.
 * It follows the CQRS pattern by separating read operations from write operations.
 *
 * As part of the query side of CQRS, this object is processed by the CustomersQueryService
 * to retrieve the full collection of customer records. Unlike the GetAllCustomersByIdQuery,
 * this query does not require any additional parameters as it requests the entire collection.
 *
 * This immutable value object serves as a typed message passed between the application layer
 * and the domain layer, representing the intent to read customer data without modification.
 *
 * @see \App\ReservationManagement\Customers\domain\services\CustomersQueryService
 * @see \App\ReservationManagement\Customers\domain\model\aggregates\Customers
 * @see \App\ReservationManagement\Customers\domain\model\queries\GetAllCustomersByIdQuery
 */
class GetAllCustomersQuery
{
    /**
     * Create a new GetAllCustomersQuery instance
     *
     * Initializes a query object for retrieving all customers.
     * This constructor takes no parameters as it represents a request
     * for the complete collection of customer records.
     */
    public function __construct()
    {
    }
}
