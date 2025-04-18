<?php

namespace Database\Factories;

use App\ReservationManagement\Tables\domain\model\aggregates\Tables;
use Illuminate\Database\Eloquent\Factories\Factory;

class TablesFactory extends Factory
{
    protected $model = Tables::class;

    public function definition()
    {
        return [
            'numero_mesa' => $this->faker->unique()->regexify('[A-Z]-[0-9]{2}'),
            'capacidad' => $this->faker->numberBetween(2, 12),
            'ubicacion' => $this->faker->randomElement(['Terraza Norte', 'Terraza Sur', 'Interior', 'Zona VIP', 'Jardín'])
        ];
    }
}
