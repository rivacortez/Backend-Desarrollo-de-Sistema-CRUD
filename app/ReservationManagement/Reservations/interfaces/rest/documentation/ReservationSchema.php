<?php

namespace App\ReservationManagement\Reservations\interfaces\rest\documentation;

/**
 * @OA\Schema(
 *     schema="Reservation",
 *     title="Reservation Model",
 *     description="Reservation model representing a table reservation"
 * )
 */
class ReservationSchema
{
    /**
     * @OA\Property(property="id", type="integer", example=1)
     */
    public $id;

    /**
     * @OA\Property(property="fecha", type="string", format="date", example="2023-06-15")
     */
    public $fecha;

    /**
     * @OA\Property(property="hora", type="string", format="time", example="19:30:00")
     */
    public $hora;

    /**
     * @OA\Property(property="numero_de_personas", type="integer", example=4)
     */
    public $numero_de_personas;

    /**
     * @OA\Property(property="comensal_id", type="integer", example=1)
     */
    public $comensal_id;

    /**
     * @OA\Property(property="comensal", type="object", nullable=true)
     */
    public $comensal;

    /**
     * @OA\Property(property="mesa_id", type="integer", example=1)
     */
    public $mesa_id;

    /**
     * @OA\Property(property="mesa", type="object", nullable=true)
     */
    public $mesa;

    /**
     * @OA\Property(property="created_at", type="string", format="date-time", example="2023-06-15T19:30:00.000000Z")
     */
    public $created_at;

    /**
     * @OA\Property(property="updated_at", type="string", format="date-time", example="2023-06-15T19:30:00.000000Z")
     */
    public $updated_at;
}
