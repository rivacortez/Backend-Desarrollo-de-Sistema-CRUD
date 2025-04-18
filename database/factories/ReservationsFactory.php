<?php

namespace Database\Factories;

use App\ReservationManagement\Customers\domain\model\aggregates\Customers;
use App\ReservationManagement\Reservations\domain\model\aggregates\Reservations;
use App\ReservationManagement\Tables\domain\model\aggregates\Tables;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationsFactory extends Factory
{
    protected $model = Reservations::class;

    public function definition()
    {
        return [
            'fecha' => $this->faker->dateTimeBetween('+1 day', '+30 days')->format('Y-m-d'),
            'hora' => $this->faker->time('H:i:s'),
            'numero_de_personas' => $this->faker->numberBetween(1, 10),
            'comensal_id' => Customers::factory(),
            'mesa_id' => Tables::factory()
        ];
    }
}
