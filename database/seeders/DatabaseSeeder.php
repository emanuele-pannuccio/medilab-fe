<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Report;
use App\Models\User;
use Database\Factories\PatientFactory;
use Database\Factories\ReportFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class
        ]);

        Patient::factory()->count(5)->create();
        User::factory()->count(10)->create();

        Report::factory()->count(10)->create();


    }
}
