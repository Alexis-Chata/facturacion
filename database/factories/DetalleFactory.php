<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DetalleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $cantidad = $this->faker->numberBetween(1,5);
        $precio = $this->faker->numberBetween(1,20);
        return [
            'descripcion' => $this->faker->sentence(),
            'cantidad' => $cantidad,
            'precio' => $precio,
            'importe' => $cantidad*$precio,
        ];
    }
}
