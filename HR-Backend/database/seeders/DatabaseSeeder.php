<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            // Add departments and jobs first since other seeders depend on them
            DepartmentSeeder::class,


            // Then run the rest of the seeders
            HealthCarePlanSeeder::class,

            MonthlyPayrollSeeder::class,
        ]);
    }
}
