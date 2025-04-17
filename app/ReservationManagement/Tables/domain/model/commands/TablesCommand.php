<?php

namespace App\ReservationManagement\Tables\domain\model\commands;

class TablesCommand
{
    public $id;
    public $numero_mesa;
    public $capacidad;
    public $ubicacion;

    public function __construct($id = null, $numero_mesa = null, $capacidad = null, $ubicacion = null)
    {
        $this->id = $id;
        $this->numero_mesa = $numero_mesa;
        $this->capacidad = $capacidad;
        $this->ubicacion = $ubicacion;
    }
}
