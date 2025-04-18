<?php

namespace App\ReservationManagement\Tables\domain\services;

use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesQuery;
use App\ReservationManagement\Tables\Domain\Model\Queries\GetAllTablesByIdQuery;

/**
 * Tables Query Service Interface
 *
 * This interface defines the contract for handling table queries within the
 * Reservation Management bounded context. It serves as a primary port in the hexagonal
 * architecture pattern, connecting the application layer to the domain layer.
 *
 * The Query Service follows the Query pattern from CQRS (Command Query Responsibility Segregation)
 * to encapsulate operations that read table data without modifying state, providing
 * a clear separation between query and command operations.
 *
 * Implementations of this interface are responsible for:
 * - Retrieving all table records
 * - Finding specific tables by their unique identifier
 *
 * This interface belongs to the domain layer and helps maintain the integrity of the
 * domain model by defining read operations that can be performed on table entities.
 */
interface TablesQueryService
{
    /**
     * Execute a query to retrieve all tables
     *
     * Process the query to fetch all table records from the persistence layer.
     * The implementation should handle any filtering or sorting as required by the
     * application needs.
     *
     * @param GetAllTablesQuery $query The query object representing the retrieval request
     * @return mixed Collection of table entities
     */
    public function execute(GetAllTablesQuery $query);

    /**
     * Execute a query to retrieve a specific table by ID
     *
     * Process the query to fetch a single table record by its unique identifier.
     * The implementation should verify the table's existence and return the
     * appropriate entity or throw an exception if not found.
     *
     * @param GetAllTablesByIdQuery $query The query object containing the table ID
     * @return mixed The requested table entity
     * @throws \App\ReservationManagement\Tables\domain\exeptions\TableNotFoundException When no table exists with the provided ID
     */
    public function executeById(GetAllTablesByIdQuery $query);
}
