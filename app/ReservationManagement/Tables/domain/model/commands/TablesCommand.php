<?php

namespace App\ReservationManagement\Tables\domain\model\commands;

/**
 * Tables Command
 *
 * This class represents a command object within the Command pattern implementation
 * for the Tables bounded context in the Reservation Management system. It encapsulates
 * all the data required for creation or modification operations on table entities.
 *
 * As part of the domain model's command layer, this object serves as a data
 * transfer object (DTO) that carries table information from the interface
 * layer to the application services, maintaining a clean separation of concerns
 * between these layers and following Domain-Driven Design principles.
 *
 * When the ID is null, this command is interpreted as a creation request.
 * When the ID is provided, it's interpreted as an update request for an existing table.
 */
class TablesCommand
{
    /**
     * The unique identifier of the table (null for new tables)
     *
     * @var int|null
     */
    public $id;

    /**
     * The table number or identifier (e.g., "A-12")
     *
     * @var string|null
     */
    public $numero_mesa;

    /**
     * The seating capacity of the table
     *
     * @var int|null
     */
    public $capacidad;

    /**
     * The location of the table within the restaurant
     *
     * @var string|null
     */
    public $ubicacion;

    /**
     * Create a new tables command instance
     *
     * @param int|null    $id           Table ID (null for new tables)
     * @param string|null $numero_mesa  Table number or identifier
     * @param int|null    $capacidad    Table seating capacity
     * @param string|null $ubicacion    Table location within the restaurant
     */
    public function __construct($id = null, $numero_mesa = null, $capacidad = null, $ubicacion = null)
    {
        $this->id = $id;
        $this->numero_mesa = $numero_mesa;
        $this->capacidad = $capacidad;
        $this->ubicacion = $ubicacion;
    }
}
