<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $status = $this->faker->randomElement(Payment::getPaymentStatuses());

        $data = [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'payment_mode' => $this->faker->randomElement(Payment::getPaymentModes()),
            'account_number' => $this->faker->randomNumber(8),
            'payment_id' => $this->faker->uuid,
            'status' => $status,
            'payment_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];

        if ($status === 'confirmed') {
            $data['receipt'] = $this->faker->imageUrl();
        }

        return $data;
    }
}
