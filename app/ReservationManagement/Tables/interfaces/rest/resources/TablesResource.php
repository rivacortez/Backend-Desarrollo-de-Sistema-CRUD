<?php

namespace App\ReservationManagement\Tables\interfaces\rest\resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Tables API Resource
 *
 * This class represents the transformation layer for table data in the REST interface,
 * converting domain table entities into structured JSON responses suitable for API clients.
 * It follows Laravel's API Resource pattern to provide consistent, controlled data exposure
 * through the REST API.
 *
 * Located in the interface layer of the hexagonal architecture, this resource:
 * - Standardizes the JSON structure for table data
 * - Controls which domain data is exposed to external clients
 * - Formats data consistently with the API's schema requirements
 * - Ensures proper representation of restaurant table information
 *
 * This resource is used by the TablesController to format both individual table
 * responses and collections of tables, ensuring a consistent API representation regardless
 * of the context in which table data is returned.
 *
 * @see \App\ReservationManagement\Tables\interfaces\rest\TablesController
 * @see \App\ReservationManagement\Tables\domain\model\aggregates\Tables
 */
class TablesResource extends JsonResource
{
    /**
     * Transform the table entity into an API-friendly array
     *
     * Converts a Tables domain entity into a structured array representation
     * suitable for JSON responses. The method ensures that only appropriate data
     * is exposed and properly formatted for API consumers.
     *
     * @param \Illuminate\Http\Request $request The current HTTP request
     * @return array The formatted table data for the API response
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,                       // Unique identifier for the table
            'numero_mesa' => $this->numero_mesa,     // Table number/code (e.g., "A-12")
            'capacidad' => $this->capacidad,         // Seating capacity of the table
            'ubicacion' => $this->ubicacion,         // Location of the table in the restaurant
            'created_at' => $this->created_at,       // Timestamp of when the record was created
            'updated_at' => $this->updated_at,       // Timestamp of when the record was last updated
        ];
    }
}
