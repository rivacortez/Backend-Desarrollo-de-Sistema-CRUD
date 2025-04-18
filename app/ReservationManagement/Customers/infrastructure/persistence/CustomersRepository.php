<?php

namespace App\ReservationManagement\Customers\infrastructure\persistence;

use App\ReservationManagement\Customers\domain\exeptions\CustomersCreationException;
use App\ReservationManagement\Customers\domain\exeptions\CustomersDeletionException;
use App\ReservationManagement\Customers\domain\exeptions\CustomersNotFoundException;
use App\ReservationManagement\Customers\domain\exeptions\CustomersUpdateException;
use App\ReservationManagement\Customers\Domain\Model\Aggregates\Customers;
use Illuminate\Support\Facades\Validator;

/**
 * Customers Repository
 *
 * This class implements the repository pattern for the Customers aggregate root,
 * providing persistence operations for customer entities within the Reservation Management system.
 * It serves as the infrastructure layer implementation that bridges domain models with the database.
 *
 * The repository encapsulates all database access logic and provides a clean API for:
 * - Retrieving customer data (individual or collections)
 * - Persisting new customer records
 * - Updating existing customer information
 * - Removing customer records
 *
 * Each operation performs data validation and proper error handling through domain-specific
 * exceptions, maintaining the integrity of the domain model.
 */
class CustomersRepository
{
    /**
     * Retrieve all customers from the database
     *
     * Fetches the complete collection of customer records without filtering or pagination.
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of all customer entities
     */
    public function getAll()
    {
        return Customers::all();
    }

    /**
     * Retrieve a specific customer by its unique identifier
     *
     * Fetches a single customer record that matches the provided ID.
     *
     * @param int $id The unique identifier of the customer to retrieve
     * @return Customers The requested customer entity
     * @throws CustomersNotFoundException When no customer exists with the provided ID
     */
    public function getById($id)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            throw new CustomersNotFoundException("Customer with ID {$id} not found");
        }

        return $customer;
    }

    /**
     * Create a new customer record in the database
     *
     * Validates and persists customer data as a new record.
     * The validation rules are obtained from the Customers model.
     *
     * @param array $data Associative array containing customer attributes
     * @return Customers The newly created customer entity with its assigned ID
     * @throws CustomersCreationException When validation fails or database errors occur
     */
    public function store(array $data)
    {
        $validator = Validator::make($data, (new Customers())->rules());

        if ($validator->fails()) {
            throw new CustomersCreationException($validator->errors()->first());
        }

        try {
            return Customers::create($data);
        } catch (\Exception $e) {
            throw new CustomersCreationException("Failed to create customer: " . $e->getMessage());
        }
    }

    /**
     * Update an existing customer record in the database
     *
     * Validates and applies changes to an existing customer record.
     * The validation rules are obtained from the existing customer model.
     *
     * @param int $id The unique identifier of the customer to update
     * @param array $data Associative array containing updated customer attributes
     * @return Customers The updated customer entity
     * @throws CustomersNotFoundException When no customer exists with the provided ID
     * @throws CustomersUpdateException When validation fails or database errors occur
     */
    public function update($id, array $data)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            throw new CustomersNotFoundException("Customer with ID {$id} not found");
        }

        $validator = Validator::make($data, $customer->rules());

        if ($validator->fails()) {
            throw new CustomersUpdateException($validator->errors()->first());
        }

        try {
            $customer->update($data);
            return $customer;
        } catch (\Exception $e) {
            throw new CustomersUpdateException("Failed to update customer: " . $e->getMessage());
        }
    }

    /**
     * Delete a customer record from the database
     *
     * Removes an existing customer record permanently.
     *
     * @param int $id The unique identifier of the customer to delete
     * @return bool True if deletion was successful
     * @throws CustomersNotFoundException When no customer exists with the provided ID
     * @throws CustomersDeletionException When database errors occur during deletion
     */
    public function delete($id)
    {
        $customer = Customers::find($id);

        if (!$customer) {
            throw new CustomersNotFoundException("Customer with ID {$id} not found");
        }

        try {
            return $customer->delete();
        } catch (\Exception $e) {
            throw new CustomersDeletionException("Failed to delete customer: " . $e->getMessage());
        }
    }
}
