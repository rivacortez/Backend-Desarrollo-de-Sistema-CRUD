<?php

namespace App\ReservationManagement\Customers\domain\model\aggregates;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $fillable = ['nombre', 'correo', 'telefono', 'direccion'];

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:customers,correo,' . $this->id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ];
    }
}
