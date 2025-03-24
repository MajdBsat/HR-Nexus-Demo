<?php

namespace Database\Seeders;

use App\Models\HealthCarePlan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthCarePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some user IDs to associate with health care plans
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            // Create a user if none exists
            $user = User::factory()->create();
            $userIds = [$user->id];
        }

        // Sample health care plans data
        $healthCarePlans = [
            [
                'user_id' => $userIds[array_rand($userIds)],
                'plan_name' => 'Comprehensive Health Plan',
                'description' => 'Full coverage health plan with dental and vision',
                'provider' => 'Blue Cross Blue Shield',
                'coverage_type' => 'Family',
                'coverage_details' => json_encode([
                    'medical' => true,
                    'dental' => true,
                    'vision' => true,
                    'mental_health' => true,
                    'prescription' => true
                ]),
                'premium_amount' => 450.00,
                'deductible_amount' => 1000.00,
                'copay_amount' => 25.00,
                'enrollment_date' => now()->subMonths(2),
                'effective_date' => now()->subMonths(1),
                'expiry_date' => now()->addYears(1),
                'status' => 'active',
                'dependents' => json_encode([
                    ['name' => 'Jane Doe', 'relationship' => 'Spouse'],
                    ['name' => 'John Doe Jr', 'relationship' => 'Child']
                ])
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'plan_name' => 'Basic Health Plan',
                'description' => 'Basic coverage for medical emergencies',
                'provider' => 'Aetna',
                'coverage_type' => 'Individual',
                'coverage_details' => json_encode([
                    'medical' => true,
                    'dental' => false,
                    'vision' => false,
                    'mental_health' => false,
                    'prescription' => true
                ]),
                'premium_amount' => 250.00,
                'deductible_amount' => 2000.00,
                'copay_amount' => 35.00,
                'enrollment_date' => now()->subMonths(3),
                'effective_date' => now()->subMonths(2),
                'expiry_date' => now()->addYears(1),
                'status' => 'active',
                'dependents' => null
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'plan_name' => 'Premium Health Plan',
                'description' => 'Premium coverage with low deductibles',
                'provider' => 'United Healthcare',
                'coverage_type' => 'Family',
                'coverage_details' => json_encode([
                    'medical' => true,
                    'dental' => true,
                    'vision' => true,
                    'mental_health' => true,
                    'prescription' => true,
                    'physical_therapy' => true
                ]),
                'premium_amount' => 650.00,
                'deductible_amount' => 500.00,
                'copay_amount' => 15.00,
                'enrollment_date' => now()->subMonths(1),
                'effective_date' => now(),
                'expiry_date' => now()->addYears(1),
                'status' => 'active',
                'dependents' => json_encode([
                    ['name' => 'Jane Doe', 'relationship' => 'Spouse'],
                    ['name' => 'John Doe Jr', 'relationship' => 'Child'],
                    ['name' => 'Jane Doe Jr', 'relationship' => 'Child']
                ])
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'plan_name' => 'Dental & Vision Plan',
                'description' => 'Specialized plan for dental and vision coverage',
                'provider' => 'Delta Dental',
                'coverage_type' => 'Individual',
                'coverage_details' => json_encode([
                    'medical' => false,
                    'dental' => true,
                    'vision' => true,
                    'mental_health' => false,
                    'prescription' => false
                ]),
                'premium_amount' => 150.00,
                'deductible_amount' => 300.00,
                'copay_amount' => 20.00,
                'enrollment_date' => now()->subMonths(4),
                'effective_date' => now()->subMonths(3),
                'expiry_date' => now()->addMonths(9),
                'status' => 'active',
                'dependents' => null
            ],
            [
                'user_id' => $userIds[array_rand($userIds)],
                'plan_name' => 'Expired Health Plan',
                'description' => 'Previously active plan that has now expired',
                'provider' => 'Cigna',
                'coverage_type' => 'Individual',
                'coverage_details' => json_encode([
                    'medical' => true,
                    'dental' => true,
                    'vision' => false,
                    'mental_health' => false,
                    'prescription' => true
                ]),
                'premium_amount' => 350.00,
                'deductible_amount' => 1500.00,
                'copay_amount' => 30.00,
                'enrollment_date' => now()->subYears(2),
                'effective_date' => now()->subYears(2)->addDays(15),
                'expiry_date' => now()->subMonths(2),
                'status' => 'expired',
                'dependents' => null
            ]
        ];

        // Insert the health care plans
        foreach ($healthCarePlans as $plan) {
            HealthCarePlan::create($plan);
        }
    }
}
