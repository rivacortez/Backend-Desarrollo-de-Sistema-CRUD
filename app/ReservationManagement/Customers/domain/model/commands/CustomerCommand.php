<?php

namespace App\ReservationManagement\Customers\Domain\Model\Commands;

class CustomerCommand
{
    public $id;
    public $nombre;
    public $correo;
    public $telefono;
    public $direccion;

    public function __construct($id = null, $nombre = null, $correo = null, $telefono = null, $direccion = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
    }
}
