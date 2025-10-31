<?php

namespace Database\Factories;

use App\MedicalCaseStatus;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $is_even = rand() % 2 == 0;

        return [
            "hospitalization_date" => fake()->dateTime(),
            "present_illness_history" => fake()->realText(),
            "past_illness_history" => fake()->realText(),
            "clinical_evolution" => $is_even ? fake()->realText() : null,
            "discharge_date" => $is_even ? fake()->dateTime() : null,
            "discharge_description" => $is_even ? fake()->realText() : null,
            "patientId" => Patient::inRandomOrder()->first()->id,
            "doctorId" => User::inRandomOrder()->first()->id,
            "status" => $is_even ? "Chiuso" : array_column(MedicalCaseStatus::cases(), 'value')[rand() % count(array_column(MedicalCaseStatus::cases(), 'value'))]
        ];
    }
}
