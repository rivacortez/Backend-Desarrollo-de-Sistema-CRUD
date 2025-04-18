<?php

namespace App\ReservationManagement\Customers\interfaces\rest\documentation;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     title="Customer Model",
 *     description="Customer model representing a restaurant customer"
 * )
 */
class CustomersSchema
{
    /**
     * @OA\Property(property="id", type="integer", example=1)
     */
    public $id;

    /**
     * @OA\Property(property="nombre", type="string", example="Juan Pérez")
     */
    public $nombre;

    /**
     * @OA\Property(property="correo", type="string", format="email", example="juan.perez@example.com")
     */
    public $correo;

    /**
     * @OA\Property(property="telefono", type="string", example="555-123-4567")
     */
    public $telefono;

    /**
     * @OA\Property(property="direccion", type="string", example="Av. Insurgentes Sur 123, CDMX")
     */
    public $direccion;

    /**
     * @OA\Property(property="created_at", type="string", format="date-time", example="2023-06-15T19:30:00.000000Z")
     */
    public $created_at;

    /**
     * @OA\Property(property="updated_at", type="string", format="date-time", example="2023-06-15T19:30:00.000000Z")
     */
    public $updated_at;
}
