<?php

namespace App\ReservationManagement\Tables\domain\model\queries;

/**
 * Table By ID Query Object
 *
 * This class represents a query object within the Command Query Responsibility Segregation (CQRS) pattern
 * implementation for the Reservation Management context. It encapsulates the data required to retrieve
 * a specific table by its unique identifier.
 *
 * As part of the domain model's query layer, this object serves as a specialized carrier for
 * query parameters, following the Query Object pattern. It provides a structured way to request
 * table data from the infrastructure layer through query services, maintaining a clean
 * separation of concerns between layers.
 *
 * This query is consumed by the TablesQueryService to fetch a single table entity
 * from the persistence store based on the provided ID.
 *
 * @see \App\ReservationManagement\Tables\domain\services\TablesQueryService
 * @see \App\ReservationManagement\Tables\application\internal\queryservices\TablesQueryServiceImpl
 */
class GetAllTablesByIdQuery
{
    /**
     * The unique identifier of the table to retrieve
     *
     * @var int
     */
    public $id;

    /**
     * Creates a new query instance for retrieving a table by ID
     *
     * @param int $id The unique identifier of the table to retrieve
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
}
