<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Payment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'payment_id' => fake()->bankAccountNumber,
            'payer_id' => fake()->bankAccountNumber,
            'payer_email' => fake()->unique()->safeEmail(),
            'amount' => fake()->unique()->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10),
            'currency' => 'USD',
            'payment_status' => Arr::random(Payment::STATUS),
        ];
    }
}
