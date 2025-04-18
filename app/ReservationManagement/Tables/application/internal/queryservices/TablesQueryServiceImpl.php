<?php

namespace App\ReservationManagement\Tables\application\internal\queryservices;

use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesByIdQuery;
use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesQuery;
use App\ReservationManagement\Tables\Domain\Services\TablesQueryService;
use App\ReservationManagement\Tables\infrastructure\persistence\TablesRepository;

/**
 * Tables Query Service Implementation
 *
 * This class implements the application layer service responsible for handling table queries
 * within the Reservation Management bounded context. It serves as a mediator between the interface layer
 * (controllers) and the domain/infrastructure layers, following the CQRS pattern and Hexagonal Architecture.
 *
 * The service encapsulates all query processing logic for restaurant tables:
 * - Retrieving all table records
 * - Finding specific tables by their unique identifier
 *
 * Each operation delegates to the appropriate repository method after processing the query object,
 * maintaining separation of concerns between application flow control and persistence operations.
 *
 * This implementation follows the Dependency Inversion Principle by depending on the repository
 * abstraction rather than concrete implementations.
 */
class TablesQueryServiceImpl implements TablesQueryService
{
    /**
     * The repository instance responsible for table persistence operations
     *
     * @var TablesRepository
     */
    private $repository;

    /**
     * Constructor with dependency injection for the repository
     *
     * @param TablesRepository $repository The repository for table persistence operations
     */
    public function __construct(TablesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Execute a query to retrieve all tables
     *
     * Processes the query by delegating to the repository to fetch all table records.
     * This method implements the Query Object pattern, accepting a specific query type
     * that encapsulates the retrieval intent.
     *
     * @param GetAllTablesQuery $query The query object representing the retrieval request
     * @return \Illuminate\Database\Eloquent\Collection Collection of table entities
     */
    public function execute(GetAllTablesQuery $query)
    {
        return $this->repository->getAll();
    }

    /**
     * Execute a query to retrieve a specific table by ID
     *
     * Processes the query by extracting the ID parameter and delegating to the repository
     * to fetch the specific table record.
     *
     * @param GetAllTablesByIdQuery $query The query object containing the table ID
     * @return \App\ReservationManagement\Tables\domain\model\aggregates\Tables The found table entity
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableNotFoundException When no table exists with the provided ID
     */
    public function executeById(GetAllTablesByIdQuery $query)
    {
        return $this->repository->getById($query->id);
    }
}
