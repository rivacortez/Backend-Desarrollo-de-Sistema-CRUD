<?php

namespace App\ReservationManagement\Reservations\domain\model\queries;

/**
 * All Reservations Query Object
 *
 * This class represents a query object within the Command Query Responsibility Segregation (CQRS) pattern
 * implementation for the Reservation Management context. It encapsulates the intent to retrieve
 * all reservations from the system without additional parameters.
 *
 * As part of the domain model's query layer, this object follows the Query Object pattern,
 * providing a structured way to request reservation data from the infrastructure layer
 * through query services. It maintains a clean separation of concerns between layers and
 * supports the DDD (Domain-Driven Design) architectural approach.
 *
 * This query is consumed by the ReservationsQueryService to fetch all reservation entities
 * from the persistence store. The empty constructor signifies that there are no filtering
 * parameters - the query requests all available reservation records.
 *
 * @see \App\ReservationManagement\Reservations\domain\services\ReservationsQueryService
 * @see \App\ReservationManagement\Reservations\application\internal\queryservices\ReservationsQueryServiceImpl
 * @see \App\ReservationManagement\Reservations\domain\model\aggregates\Reservations
 */
class GetAllReservationsQuery
{
    /**
     * Creates a new query instance for retrieving all reservations
     *
     * The constructor takes no parameters as this query retrieves the complete
     * set of reservation records without filtering.
     */
    public function __construct()
    {
    }
}
