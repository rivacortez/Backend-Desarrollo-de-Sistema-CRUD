<?php

namespace App\ReservationManagement\Reservations\domain\model\aggregates;

use App\ReservationManagement\Customers\domain\model\aggregates\Customers;
use App\ReservationManagement\Tables\domain\model\aggregates\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservations extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $fillable = ['fecha', 'hora', 'numero_de_personas', 'comensal_id', 'mesa_id'];

    public function rules()
    {
        return [
            'fecha' => 'required|date',
            'hora' => 'required',
            'numero_de_personas' => 'required|integer|min:1',
            'comensal_id' => 'required|exists:customers,id',
            'mesa_id' => 'required|exists:tables,id',
        ];
    }

    public function comensal()
    {
        return $this->belongsTo(Customers::class, 'comensal_id');
    }

    public function mesa()
    {
        return $this->belongsTo(Tables::class, 'mesa_id');
    }
}
