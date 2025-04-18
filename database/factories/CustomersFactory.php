<?php

namespace Database\Factories;

use App\ReservationManagement\Customers\domain\model\aggregates\Customers;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomersFactory extends Factory
{
    protected $model = Customers::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'correo' => $this->faker->unique()->safeEmail,
            'telefono' => $this->faker->phoneNumber,
            'direccion' => $this->faker->address,
        ];
    }
}
