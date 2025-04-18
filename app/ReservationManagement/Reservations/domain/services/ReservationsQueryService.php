<?php

namespace App\ReservationManagement\Reservations\domain\services;

use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsQuery;
use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsByIdQuery;

/**
 * Reservations Query Service Interface
 *
 * This interface defines the contract for handling reservation queries within the
 * Reservation Management bounded context. It serves as a primary port in the hexagonal
 * architecture pattern, connecting the application layer to the domain layer.
 *
 * The Query Service follows the Query pattern from CQRS (Command Query Responsibility Segregation)
 * to encapsulate operations that read reservation data without modifying state, providing
 * a clear separation between query and command operations.
 *
 * Implementations of this interface are responsible for:
 * - Retrieving all reservation records
 * - Finding specific reservations by their unique identifier
 *
 * This interface belongs to the domain layer and helps maintain the integrity of the
 * domain model by defining read operations that can be performed on reservation entities.
 */
interface ReservationsQueryService
{
    /**
     * Execute a query to retrieve all reservations
     *
     * Process the query to fetch all reservation records from the persistence layer.
     * The implementation should handle any filtering or sorting as required by the
     * application needs.
     *
     * @param GetAllReservationsQuery $query The query object representing the retrieval request
     * @return mixed Collection of reservation entities
     */
    public function execute(GetAllReservationsQuery $query);

    /**
     * Execute a query to retrieve a specific reservation by ID
     *
     * Process the query to fetch a single reservation record by its unique identifier.
     * The implementation should verify the reservation's existence and return the
     * appropriate entity or throw an exception if not found.
     *
     * @param GetAllReservationsByIdQuery $query The query object containing the reservation ID
     * @return mixed The requested reservation entity
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException When no reservation exists with the provided ID
     */
    public function executeById(GetAllReservationsByIdQuery $query);
}
