<?php

namespace Database\Factories;

use App\Models\Payments\PaymentsModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentsModelFactory extends Factory
{
    protected $model = PaymentsModel::class;

    public function definition()
    {
        return [
            'client_id' => \App\Models\Clients\ClientModel::factory(),
            'user_id' => \App\Models\Auth\UserModel::factory(),
            'payment_method_id' => \App\Models\Payments\PaymentMethodModel::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed'])
        ];
    }
}
