<?php

namespace App\ReservationManagement\Tables\interfaces\rest\documentation;

/**
 * @OA\Schema(
 *     schema="Table",
 *     title="Table Model",
 *     description="Table model representing a restaurant table"
 * )
 */
class TablesSchema
{
    /**
     * @OA\Property(property="id", type="integer", example=1)
     */
    public $id;

    /**
     * @OA\Property(property="numero_mesa", type="string", example="A-12")
     */
    public $numero_mesa;

    /**
     * @OA\Property(property="capacidad", type="integer", example=4)
     */
    public $capacidad;

    /**
     * @OA\Property(property="ubicacion", type="string", example="Terraza Norte")
     */
    public $ubicacion;

    /**
     * @OA\Property(property="created_at", type="string", format="date-time", example="2023-06-15T19:30:00.000000Z")
     */
    public $created_at;

    /**
     * @OA\Property(property="updated_at", type="string", format="date-time", example="2023-06-15T19:30:00.000000Z")
     */
    public $updated_at;
}
