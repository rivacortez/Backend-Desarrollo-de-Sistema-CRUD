<?php

namespace App\ReservationManagement\Customers\interfaces\rest\resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Customers API Resource Transformer
 *
 * This resource class transforms Customer domain entities into API-friendly JSON representations,
 * following REST best practices within the Reservation Management system. It acts as a data
 * transformation layer between the domain model and the external API interface.
 *
 * The class encapsulates the presentation logic for customer data, providing a consistent
 * representation format for all customer-related API responses. This promotes separation of
 * concerns by keeping presentation logic out of controllers and domain models.
 *
 * Key responsibilities:
 * - Transforming internal customer data structures into consistent external representations
 * - Field selection and filtration for API responses
 * - Implementing the Resource pattern as part of the hexagonal architecture's interface layer
 *
 * @see \App\ReservationManagement\Customers\domain\model\aggregates\Customers
 * @see \App\ReservationManagement\Customers\interfaces\rest\CustomerController
 */
class CustomersResource extends JsonResource
{
    /**
     * Transform the customer entity into an API-friendly array
     *
     * Converts the customer domain model attributes into a structured array representation
     * suitable for JSON serialization in API responses. This ensures consistent output formatting
     * and proper data encapsulation.
     *
     * @param \Illuminate\Http\Request $request The current HTTP request instance
     * @return array The transformed customer data with selected attributes
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'correo' => $this->correo,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
