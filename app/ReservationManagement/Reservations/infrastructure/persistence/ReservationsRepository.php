<?php

namespace App\ReservationManagement\Reservations\infrastructure\persistence;

use App\ReservationManagement\Reservations\domain\exeptions\ReservationCreationException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationDeletionException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationNotFoundException;
use App\ReservationManagement\Reservations\domain\exeptions\ReservationUpdateException;
use App\ReservationManagement\Reservations\domain\model\aggregates\Reservations;
use Illuminate\Support\Facades\Validator;

class ReservationsRepository
{
    public function getAll()
    {
        return Reservations::with(['comensal', 'mesa'])->get();
    }

    public function getById($id)
    {
        $reservation = Reservations::with(['comensal', 'mesa'])->find($id);

        if (!$reservation) {
            throw new ReservationNotFoundException("Reservation with ID {$id} not found");
        }

        return $reservation;
    }

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
