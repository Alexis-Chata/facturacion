<?php

namespace Database\Factories;

use App\Models\Tcliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'paterno' => $this->faker->lastName(),
            'materno' => $this->faker->lastName(),
            'identificacion' => $this->faker->ean8(),
            'email' => $this->faker->unique()->safeEmail(),
            'direccion' => $this->faker->address(),
            'celular' => $this->faker->phoneNumber(),
            'tcliente_id' => Tcliente::all()->random()->id,
        ];
    }
}
