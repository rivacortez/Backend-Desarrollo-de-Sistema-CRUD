<?php

namespace App\ReservationManagement\Reservations\domain\model\queries;

/**
 * Reservation By ID Query Object
 *
 * This class represents a query object within the Command Query Responsibility Segregation (CQRS) pattern
 * implementation for the Reservation Management context. It encapsulates the data required to retrieve
 * a specific reservation by its unique identifier.
 *
 * As part of the domain model's query layer, this object serves as a specialized carrier for
 * query parameters, following the Query Object pattern. It provides a structured way to request
 * reservation data from the infrastructure layer through query services, maintaining a clean
 * separation of concerns between layers.
 *
 * This query is consumed by the ReservationsQueryService to fetch a single reservation entity
 * from the persistence store based on the provided ID.
 *
 * @see \App\ReservationManagement\Reservations\domain\services\ReservationsQueryService
 * @see \App\ReservationManagement\Reservations\application\internal\queryservices\ReservationsQueryServiceImpl
 */
class GetAllReservationsByIdQuery
{
    /**
     * The unique identifier of the reservation to retrieve
     *
     * @var int
     */
    public $id;

    /**
     * Creates a new query instance for retrieving a reservation by ID
     *
     * @param int $id The unique identifier of the reservation to retrieve
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
}
