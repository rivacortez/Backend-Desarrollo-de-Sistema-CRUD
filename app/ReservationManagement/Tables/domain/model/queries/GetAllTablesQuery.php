<?php

namespace App\ReservationManagement\Tables\domain\model\queries;

/**
 * All Tables Query Object
 *
 * This class represents a query object within the Command Query Responsibility Segregation (CQRS) pattern
 * implementation for the Reservation Management context. It encapsulates the intent to retrieve
 * all tables from the system without additional parameters.
 *
 * As part of the domain model's query layer, this object follows the Query Object pattern,
 * providing a structured way to request table data from the infrastructure layer
 * through query services. It maintains a clean separation of concerns between layers and
 * supports the DDD (Domain-Driven Design) architectural approach.
 *
 * This query is consumed by the TablesQueryService to fetch all table entities
 * from the persistence store. The empty constructor signifies that there are no filtering
 * parameters - the query requests all available table records.
 *
 * @see \App\ReservationManagement\Tables\domain\services\TablesQueryService
 * @see \App\ReservationManagement\Tables\application\internal\queryservices\TablesQueryServiceImpl
 * @see \App\ReservationManagement\Tables\domain\model\aggregates\Tables
 */
class GetAllTablesQuery
{
    /**
     * Creates a new query instance for retrieving all tables
     *
     * The constructor takes no parameters as this query retrieves the complete
     * set of table records without filtering.
     */
    public function __construct()
    {
    }
}
