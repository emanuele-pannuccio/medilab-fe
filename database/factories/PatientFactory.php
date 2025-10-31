<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{

    protected $model = \App\Models\Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        $birthday = fake()->numberBetween(1970,2025)."-".fake()->numberBetween(1,12)."-".fake()->numberBetween(1,31);
        $city = fake()->city();

        return [
            'name' => "pti-".hash_hmac('sha256', $name.$birthday.$city, config('app.key')),
            'birthday' => $birthday,
            'city' => $city
        ];
    }
}
