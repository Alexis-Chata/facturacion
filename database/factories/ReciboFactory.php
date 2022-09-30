<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Recibo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReciboFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'femision' => $this->faker->date(),
            'correlativo' => Recibo::all()->count()+1,
            'termino' => $this->faker->randomElement(['Deposito','Efectivo']),
            'total' => 0,
            'cajero_id' => User::all()->random()->id,
            'cliente_id' => Cliente::all()->random()->id,
        ];
    }
}
