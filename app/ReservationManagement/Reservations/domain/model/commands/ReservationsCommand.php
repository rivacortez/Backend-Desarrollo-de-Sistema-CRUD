<?php

namespace App\ReservationManagement\Reservations\domain\model\commands;

/**
 * Reservations Command
 *
 * This class represents a command object within the Command pattern implementation
 * for the Reservation Management context. It encapsulates all the data required
 * for creation or modification operations on reservation entities.
 *
 * As part of the domain model's command layer, this object serves as a data
 * transfer object (DTO) that carries reservation information from the interface
 * layer to the application services, maintaining a clean separation of concerns
 * between these layers and following Domain-Driven Design principles.
 *
 * When the ID is null, this command is interpreted as a creation request.
 * When the ID is provided, it's interpreted as an update request for an existing reservation.
 */
class ReservationsCommand
{
    /**
     * The unique identifier of the reservation (null for new reservations)
     *
     * @var int|null
     */
    public $id;

    /**
     * The date of the reservation in Y-m-d format
     *
     * @var string|null
     */
    public $fecha;

    /**
     * The time of the reservation in H:i:s format
     *
     * @var string|null
     */
    public $hora;

    /**
     * The number of people in the party for this reservation
     *
     * @var int|null
     */
    public $numero_de_personas;

    /**
     * The foreign key to the customer (comensal) making the reservation
     *
     * @var int|null
     */
    public $comensal_id;

    /**
     * The foreign key to the table (mesa) being reserved
     *
     * @var int|null
     */
    public $mesa_id;

    /**
     * Create a new reservations command instance
     *
     * @param int|null    $id                  Reservation ID (null for new reservations)
     * @param string|null $fecha               Reservation date (Y-m-d format)
     * @param string|null $hora                Reservation time (H:i:s format)
     * @param int|null    $numero_de_personas  Number of people in the party
     * @param int|null    $comensal_id         ID of the customer making the reservation
     * @param int|null    $mesa_id             ID of the table being reserved
     */
    public function __construct($id = null, $fecha = null, $hora = null, $numero_de_personas = null, $comensal_id = null, $mesa_id = null)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->numero_de_personas = $numero_de_personas;
        $this->comensal_id = $comensal_id;
        $this->mesa_id = $mesa_id;
    }
}
