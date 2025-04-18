<?php

namespace App\ReservationManagement\Reservations\infrastructure\persistence;

use App\ReservationManagement\Reservations\domain\exeptions\ReservationCreationException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationDeletionException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationUpdateException;
use App\ReservationManagement\Reservations\domain\model\aggregates\Reservations;
use Illuminate\Support\Facades\Validator;

/**
 * Reservations Repository
 *
 * This class implements the repository pattern for the Reservations aggregate root within
 * the Reservation Management bounded context. It serves as the primary infrastructure layer
 * component responsible for persisting and retrieving reservation data.
 *
 * The repository isolates the domain layer from the underlying database implementation,
 * following the Hexagonal Architecture principles. It handles all CRUD operations while
 * enforcing domain validation rules and ensuring proper exception handling for various
 * failure scenarios.
 *
 * All operations include appropriate error handling to maintain the system's reliability
 * and provide meaningful feedback when operations cannot be completed as requested.
 *
 * This implementation leverages Laravel's Eloquent ORM for data persistence while maintaining
 * a clean separation from the domain model through structured exception handling.
 */
class ReservationsRepository
{
    /**
     * Retrieve all reservations with their related entities
     *
     * Fetches all reservation records from the database and eagerly loads the
     * associated customer (comensal) and table (mesa) relationships for optimal
     * performance when accessing these related entities.
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of all reservation entities with their relationships
     */
    public function getAll()
    {
        return Reservations::with(['comensal', 'mesa'])->get();
    }

    /**
     * Retrieve a specific reservation by its unique identifier
     *
     * Fetches a single reservation record by ID and eagerly loads its
     * associated customer and table relationships. Throws an exception
     * if the requested reservation cannot be found.
     *
     * @param int $id The unique identifier of the reservation to retrieve
     * @return Reservations The found reservation entity with its relationships
     * @throws ReservationNotFoundException When no reservation exists with the provided ID
     */
    public function getById($id)
    {
        $reservation = Reservations::with(['comensal', 'mesa'])->find($id);

        if (!$reservation) {
            throw new ReservationNotFoundException("Reservation with ID {$id} not found");
        }

        return $reservation;
    }

    /**
     * Create a new reservation record
     *
     * Validates the provided data against domain rules and creates a new
     * reservation record in the database. Throws appropriate exceptions
     * for validation failures or database errors.
     *
     * @param array $data The reservation data to be stored
     * @return Reservations The newly created reservation entity
     * @throws ReservationCreationException When validation fails or database errors occur
     */
    public function store(array $data)
    {
        $validator = Validator::make($data, (new Reservations())->rules());

        if ($validator->fails()) {
            throw new ReservationCreationException($validator->errors()->first());
        }

        try {
            return Reservations::create($data);
        } catch (\Exception $e) {
            throw new ReservationCreationException("Failed to create reservation: " . $e->getMessage());
        }
    }

    /**
     * Update an existing reservation record
     *
     * Locates a reservation by ID, validates the updated data against domain rules,
     * and persists the changes to the database. Throws appropriate exceptions
     * when the reservation cannot be found, validation fails, or database errors occur.
     *
     * @param int $id The unique identifier of the reservation to update
     * @param array $data The new reservation data to be applied
     * @return Reservations The updated reservation entity
     * @throws ReservationNotFoundException When the reservation cannot be found
     * @throws ReservationUpdateException When validation fails or database errors occur
     */
    public function update($id, array $data)
    {
        $reservation = Reservations::find($id);

        if (!$reservation) {
            throw new ReservationNotFoundException("Reservation with ID {$id} not found");
        }

        $validator = Validator::make($data, $reservation->rules());

        if ($validator->fails()) {
            throw new ReservationUpdateException($validator->errors()->first());
        }

        try {
            $reservation->update($data);
            return $reservation;
        } catch (\Exception $e) {
            throw new ReservationUpdateException("Failed to update reservation: " . $e->getMessage());
        }
    }

    /**
     * Delete a reservation record from the system
     *
     * Locates a reservation by ID and removes it from the database.
     * Throws appropriate exceptions when the reservation cannot be found
     * or when database errors prevent successful deletion.
     *
     * @param int $id The unique identifier of the reservation to delete
     * @return bool True if deletion was successful
     * @throws ReservationNotFoundException When the reservation cannot be found
     * @throws ReservationDeletionException When database errors prevent deletion
     */
    public function delete($id)
    {
        $reservation = Reservations::find($id);

        if (!$reservation) {
            throw new ReservationNotFoundException("Reservation with ID {$id} not found");
        }

        try {
            return $reservation->delete();
        } catch (\Exception $e) {
            throw new ReservationDeletionException("Failed to delete reservation: " . $e->getMessage());
        }
    }
}
