<?php

namespace App\ReservationManagement\Tables\domain\model\aggregates;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tables extends Model
{
    use HasFactory;

    protected $table = 'tables';
    protected $fillable = ['numero_mesa', 'capacidad', 'ubicacion'];

    public function rules()
    {
        return [
            'numero_mesa' => 'required|string|max:20|unique:tables,numero_mesa,' . $this->id,
            'capacidad' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:255',
        ];
    }
}
