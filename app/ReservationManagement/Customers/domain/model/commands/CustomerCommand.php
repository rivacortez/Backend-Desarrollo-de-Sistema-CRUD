<?php

namespace App\ReservationManagement\Customers\domain\model\commands;

/**
 * Customer Command Value Object
 *
 * This command encapsulates the data required for customer creation and modification operations
 * within the Customers bounded context. It acts as a Data Transfer Object (DTO) between
 * the application layer and domain layer.
 *
 * As part of the CQRS pattern implementation, this command is processed by the CustomersCommandService
 * to perform write operations on the Customer aggregate root. The presence of an ID property
 * determines whether this command represents an update operation (ID present) or a
 * creation operation (ID null).
 *
 * @see \App\ReservationManagement\Customers\domain\services\CustomersCommandService
 * @see \App\ReservationManagement\Customers\Domain\Model\Aggregates\Customers
 */
class CustomerCommand
{
    /**
     * Customer identifier (null for creation operations)
     *
     * @var int|null
     */
    public $id;

    /**
     * Customer's full name
     *
     * @var string|null
     */
    public $nombre;

    /**
     * Customer's email address
     *
     * @var string|null
     */
    public $correo;

    /**
     * Customer's contact phone number
     *
     * @var string|null
     */
    public $telefono;

    /**
     * Customer's physical address
     *
     * @var string|null
     */
    public $direccion;

    /**
     * Create a new CustomerCommand instance
     *
     * @param int|null $id The customer ID (null for new customers)
     * @param string|null $nombre The customer's name
     * @param string|null $correo The customer's email address
     * @param string|null $telefono The customer's phone number
     * @param string|null $direccion The customer's physical address
     */
    public function __construct($id = null, $nombre = null, $correo = null, $telefono = null, $direccion = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
    }
}
