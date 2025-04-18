<?php

namespace App\ReservationManagement\Reservations\interfaces\rest\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'numero_de_personas' => $this->numero_de_personas,
            'comensal_id' => $this->comensal_id,
            'comensal' => $this->whenLoaded('comensal'),
            'mesa_id' => $this->mesa_id,
            'mesa' => $this->whenLoaded('mesa'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
