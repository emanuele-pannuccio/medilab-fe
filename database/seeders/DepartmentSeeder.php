<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (["Pronto Soccorso", "Odontoiatria", "Cardiologia", "Radiologia"] as $department) {
            DB::table('departments')->insert([
                'name' => $department
            ]);
        }

    }
}
