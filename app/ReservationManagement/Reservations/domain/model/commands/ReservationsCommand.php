<?php

namespace App\ReservationManagement\Reservations\domain\model\commands;

class ReservationsCommand
{
    public $id;
    public $fecha;
    public $hora;
    public $numero_de_personas;
    public $comensal_id;
    public $mesa_id;

    public function __construct($id = null, $fecha = null, $hora = null, $numero_de_personas = null, $comensal_id = null, $mesa_id = null)
    {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->numero_de_personas = $numero_de_personas;
        $this->comensal_id = $comensal_id;
        $this->mesa_id = $mesa_id;
    }
}
