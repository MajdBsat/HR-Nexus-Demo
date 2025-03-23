<?php

namespace Database\Seeders;

use App\Models\InsurancePlan;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobInsurancePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::all();
        $insurancePlans = InsurancePlan::all();

        if ($jobs->isEmpty()) {
            $this->command->info('No jobs found to create job insurance plan associations!');
            return;
        }

        if ($insurancePlans->isEmpty()) {
            $this->command->info('No insurance plans found to create job insurance plan associations!');
            return;
        }

        // Create associations between jobs and insurance plans
        foreach ($jobs as $job) {
            // Determine number of insurance plans to associate with this job (1-3)
            $numPlans = rand(1, 3);

            // Get random insurance plans
            $selectedPlans = $insurancePlans->random(min($numPlans, $insurancePlans->count()));

            foreach ($selectedPlans as $plan) {
                // Generate dates
                $startDate = Carbon::now()->subMonths(rand(0, 6));
                $endDate = (rand(0, 1)) ? $startDate->copy()->addYear() : null;

                // Create metadata
                $metadata = json_encode([
                    'eligibility_criteria' => [
                        'min_employment_duration' => rand(1, 12) . ' months',
                        'job_status' => ['Full-time', 'Part-time', 'Contract'][array_rand(['Full-time', 'Part-time', 'Contract'])],
                        'probation_period' => rand(30, 90) . ' days'
                    ],
                    'benefits_tier' => ['Basic', 'Standard', 'Premium'][array_rand(['Basic', 'Standard', 'Premium'])],
                    'coverage_percentage' => rand(60, 100) . '%',
                    'additional_notes' => 'Standard coverage for this position'
                ]);

                // Create the association
                DB::table('job_insurance_plans')->insert([
                    'job_id' => $job->id,
                    'insurance_plan_id' => $plan->id,
                    'details' => 'This insurance plan is available for ' . $job->title . ' positions',
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'metadata' => $metadata,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        $this->command->info('Job insurance plans seeded successfully!');
    }
}
