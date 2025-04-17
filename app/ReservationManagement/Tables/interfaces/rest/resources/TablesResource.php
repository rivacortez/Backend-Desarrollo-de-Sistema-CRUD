<?php

namespace App\ReservationManagement\Tables\interfaces\rest\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TablesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'numero_mesa' => $this->numero_mesa,
            'capacidad' => $this->capacidad,
            'ubicacion' => $this->ubicacion,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
