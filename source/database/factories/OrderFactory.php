<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Str::random(12),
            'name' => "{$this->faker->colorName}-" . Str::random(3),
            'settlement_at' => $this->faker->dateTimeInInterval('-90 days', '+90 days')
        ];
    }
}
