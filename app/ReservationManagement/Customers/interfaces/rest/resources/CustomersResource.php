<?php

namespace App\ReservationManagement\Customers\Interfaces\Rest\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomersResource extends JsonResource
{
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
