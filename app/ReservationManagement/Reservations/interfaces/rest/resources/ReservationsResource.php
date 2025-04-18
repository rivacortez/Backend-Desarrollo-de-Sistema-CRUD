<?php

namespace App\ReservationManagement\Reservations\interfaces\rest\resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Reservations API Resource
 *
 * This class represents the transformation layer for reservation data in the REST interface,
 * converting domain reservation entities into structured JSON responses suitable for API clients.
 * It follows Laravel's API Resource pattern to provide consistent, controlled data exposure
 * through the REST API.
 *
 * Located in the interface layer of the hexagonal architecture, this resource:
 * - Standardizes the JSON structure for reservation data
 * - Controls which domain data is exposed to external clients
 * - Handles conditional inclusion of related entities (customer and table)
 * - Formats data consistently with the API's schema requirements
 *
 * This resource is used by the ReservationsController to format both individual reservation
 * responses and collections of reservations, ensuring a consistent API representation regardless
 * of the context in which reservation data is returned.
 *
 * @see \App\ReservationManagement\Reservations\interfaces\rest\ReservationsController
 * @see \App\ReservationManagement\Reservations\domain\model\aggregates\Reservations
 */
class ReservationsResource extends JsonResource
{
    /**
     * Transform the reservation entity into an API-friendly array
     *
     * Converts a Reservations domain entity into a structured array representation
     * suitable for JSON responses. The method ensures that only appropriate data
     * is exposed and properly formatted for API consumers.
     *
     * Relationship data (comensal/customer and mesa/table) is conditionally included
     * only when these relationships have been explicitly loaded, preventing N+1 query
     * issues and allowing API consumers to receive the appropriate level of detail
     * based on the endpoint context.
     *
     * @param \Illuminate\Http\Request $request The current HTTP request
     * @return array The formatted reservation data for the API response
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,                                 // Unique identifier for the reservation
            'fecha' => $this->fecha,                           // Date of the reservation (Y-m-d)
            'hora' => $this->hora,                             // Time of the reservation (H:i:s)
            'numero_de_personas' => $this->numero_de_personas, // Party size for the reservation
            'comensal_id' => $this->comensal_id,               // Foreign key to the customer
            'comensal' => $this->whenLoaded('comensal'),       // Customer data, included only when relationship is loaded
            'mesa_id' => $this->mesa_id,                       // Foreign key to the reserved table
            'mesa' => $this->whenLoaded('mesa'),               // Table data, included only when relationship is loaded
            'created_at' => $this->created_at,                 // Timestamp of when the record was created
            'updated_at' => $this->updated_at,                 // Timestamp of when the record was last updated
        ];
    }
}
