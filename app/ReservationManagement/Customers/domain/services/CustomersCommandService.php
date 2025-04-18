<?php

namespace App\ReservationManagement\Customers\domain\services;

use App\ReservationManagement\Customers\Domain\Model\Commands\CustomerCommand;

/**
 * Customers Command Service Interface
 *
 * This interface defines the contract for handling command operations within the Customers
 * bounded context of the Reservation Management system. It is part of the domain layer and
 * follows the Command Query Responsibility Segregation (CQRS) pattern, focusing on the
 * command (write) side of operations.
 *
 * The command service is responsible for processing customer-related write operations like
 * create, update, and delete. It receives immutable command objects that encapsulate the
 * intent and data for these operations, ensuring a clear separation between the command model
 * and the query model.
 *
 * Implementation classes should handle validation, business rule enforcement, and persistence
 * coordination for customer data modifications.
 *
 * @see \App\ReservationManagement\Customers\Domain\Model\Commands\CustomerCommand
 * @see \App\ReservationManagement\Customers\Domain\Model\Aggregates\Customers
 * @see \App\ReservationManagement\Customers\domain\services\CustomersQueryService
 */
interface CustomersCommandService
{
    /**
     * Process a customer command
     *
     * Handles the creation or update of a customer entity based on the provided command.
     * If the command contains an ID, it performs an update operation; otherwise, it creates
     * a new customer record.
     *
     * @param CustomerCommand $command The immutable command containing customer data
     * @return mixed The processed customer entity
     * @throws \App\ReservationManagement\Customers\domain\exeptions\CustomersCreationException When customer creation fails
     * @throws \App\ReservationManagement\Customers\domain\exeptions\CustomersUpdateException When customer update fails
     * @throws \App\ReservationManagement\Customers\domain\exeptions\CustomersNotFoundException When updating a non-existent customer
     */
    public function handle(CustomerCommand $command);

    /**
     * Delete a customer by ID
     *
     * Removes a customer record from the system. This operation may be subject to
     * business rules that prevent deletion in certain circumstances (e.g., if the
     * customer has active reservations).
     *
     * @param int $id The unique identifier of the customer to delete
     * @return mixed Operation result
     * @throws \App\ReservationManagement\Customers\domain\exeptions\CustomersNotFoundException When customer doesn't exist
     * @throws \App\ReservationManagement\Customers\domain\exeptions\CustomersDeletionException When deletion fails
     */
    public function delete($id);
}
