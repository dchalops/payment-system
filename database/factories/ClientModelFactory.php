<?php

namespace Database\Factories;

use App\Models\Clients\ClientModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientModelFactory extends Factory
{
    protected $model = ClientModel::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber
        ];
    }
}
