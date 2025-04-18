<?php

namespace App\ReservationManagement\Reservations\interfaces\rest\requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fecha' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'hora' => 'required|date_format:H:i:s',
            'numero_de_personas' => 'required|integer|min:1',
            'comensal_id' => 'required|exists:customers,id',
            'mesa_id' => 'required|exists:tables,id',
        ];
    }

    public function messages()
    {
        return [
            'fecha.after_or_equal' => 'La fecha de reserva debe ser hoy o posterior.',
            'comensal_id.exists' => 'El cliente seleccionado no existe.',
            'mesa_id.exists' => 'La mesa seleccionada no existe.',
        ];
    }
}
