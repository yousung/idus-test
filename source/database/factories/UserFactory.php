<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randGender = rand(0 , 1);
        $gender = ['female', 'male'];

        return [
            'name' => $this->faker->name($gender[$randGender]),
            'nickname' => $this->faker->userName,
            'password' => '!password1',
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'gender' => rand(0, 1) ? User::GENDER[$randGender] : null,
        ];
    }
}
