<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $this->faker->addProvider(new \Faker\Provider\pt_BR\Person($this->faker));

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'cpf' => $this->faker->cpf(false),
            'balance' => $this->faker->numberBetween(100,1000),
            'user_type_id' => mt_rand(1,2),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function common()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type_id' => UserType::whereName('Comum')->first()->id,
            ];
        });
    }

    public function shopkeeper()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type_id' => UserType::whereName('Lojista')->first()->id,
            ];
        });
    }
}
