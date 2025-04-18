<?php

namespace App\ReservationManagement\Reservations\application\internal\queryservices;

use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsByIdQuery;
use App\ReservationManagement\Reservations\domain\model\queries\GetAllReservationsQuery;
use App\ReservationManagement\Reservations\domain\services\ReservationsQueryService;
use App\ReservationManagement\Reservations\infrastructure\persistence\ReservationsRepository;

/**
 * Reservations Query Service Implementation
 *
 * This class implements the application layer service responsible for handling reservation queries
 * within the Reservation Management bounded context. It serves as a mediator between the interface layer
 * (controllers) and the domain/infrastructure layers, following the CQRS pattern and Hexagonal Architecture.
 *
 * The service encapsulates all query processing logic for reservations:
 * - Retrieving all reservation records
 * - Finding specific reservations by their unique identifier
 *
 * Each operation delegates to the appropriate repository method after processing the query object,
 * maintaining separation of concerns between application flow control and persistence operations.
 *
 * This implementation follows the Dependency Inversion Principle by depending on the repository
 * abstraction rather than concrete implementations.
 */
class ReservationsQueryServiceImpl implements ReservationsQueryService
{
    /**
     * The repository instance responsible for reservation persistence operations
     *
     * @var ReservationsRepository
     */
    private $repository;

    /**
     * Constructor with dependency injection for the repository
     *
     * @param ReservationsRepository $repository The repository for reservation persistence operations
     */
    public function __construct(ReservationsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Execute a query to retrieve all reservations
     *
     * Processes the query by delegating to the repository to fetch all reservation records.
     * This method implements the Query Object pattern, accepting a specific query type
     * that encapsulates the retrieval intent.
     *
     * @param GetAllReservationsQuery $query The query object representing the retrieval request
     * @return \Illuminate\Database\Eloquent\Collection Collection of reservation entities
     */
    public function execute(GetAllReservationsQuery $query)
    {
        return $this->repository->getAll();
    }

    /**
     * Execute a query to retrieve a specific reservation by ID
     *
     * Processes the query by extracting the ID parameter and delegating to the repository
     * to fetch the specific reservation record.
     *
     * @param GetAllReservationsByIdQuery $query The query object containing the reservation ID
     * @return \App\ReservationManagement\Reservations\domain\model\aggregates\Reservations The found reservation entity
     * @throws \App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException When no reservation exists with the provided ID
     */
    public function executeById(GetAllReservationsByIdQuery $query)
    {
        return $this->repository->getById($query->id);
    }
}
