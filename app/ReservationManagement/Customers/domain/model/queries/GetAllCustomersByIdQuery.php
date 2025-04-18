<?php

namespace App\ReservationManagement\Customers\domain\model\queries;

/**
 * Customer Retrieval Query Value Object
 *
 * This query encapsulates the data required to retrieve a specific customer record by its ID
 * within the Customers bounded context. It follows the CQRS pattern by separating read operations
 * from write operations.
 *
 * As part of the query side of CQRS, this object is processed by the CustomersQueryService
 * to retrieve customer data. It contains only the minimum information needed to identify
 * the requested customer (the ID).
 *
 * @see \App\ReservationManagement\Customers\domain\services\CustomersQueryService
 * @see \App\ReservationManagement\Customers\Domain\Model\Aggregates\Customers
 */
class GetAllCustomersByIdQuery
{
    /**
     * The unique identifier of the customer to retrieve
     *
     * @var int
     */
    public $id;

    /**
     * Create a new GetAllCustomersByIdQuery instance
     *
     * @param int $id The unique identifier of the customer to retrieve
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
}
