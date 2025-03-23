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
            DepartmentSeeder::class,
            JobSeeder::class,
            HealthCarePlanSeeder::class,
            HrProjectSeeder::class,
            TaskSeeder::class,
            InsurancePlanSeeder::class,
            JobInsurancePlanSeeder::class,
            HrProjectTaskSeeder::class,
            MonthlyPayrollSeeder::class,
            JobApplicationSeeder::class,
            RoleSeeder::class,
            BenefitPlanSeeder::class,
            AttendanceSeeder::class,
            BaseSalarySeeder::class,
            CandidateSeeder::class,
            ComplianceSeeder::class,
            DocumentSeeder::class,
            OnboardingTaskSeeder::class,
        ]);
    }
}
