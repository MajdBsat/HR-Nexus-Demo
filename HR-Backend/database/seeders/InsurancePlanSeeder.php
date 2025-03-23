<?php

namespace Database\Seeders;

use App\Models\InsurancePlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InsurancePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found to create insurance plans!');
            return;
        }

        $insuranceTypes = [
            'Health',
            'Life',
            'Dental',
            'Vision',
            'Disability',
            'Accident',
            'Critical Illness'
        ];

        $providers = [
            'BlueCross BlueShield',
            'UnitedHealthcare',
            'Aetna',
            'Cigna',
            'Humana',
            'Kaiser Permanente',
            'MetLife',
            'Prudential'
        ];

        $statuses = ['Active', 'Pending', 'Expired'];

        // Create 1-2 insurance plans for each user
        foreach ($users as $user) {
            $numPlans = rand(1, 2);

            for ($i = 0; $i < $numPlans; $i++) {
                $type = $insuranceTypes[array_rand($insuranceTypes)];
                $provider = $providers[array_rand($providers)];
                $status = $statuses[array_rand($statuses)];

                // Generate random dates
                $startDate = Carbon::now()->subMonths(rand(1, 24));
                $endDate = (rand(0, 1)) ? $startDate->copy()->addYear() : null;
                $renewalDate = $endDate ? $endDate->copy()->subDays(30) : null;

                // Generate random amounts
                $premiumAmount = rand(100, 1000);
                $deductibleAmount = rand(500, 5000);
                $coverageLimit = rand(50000, 2000000);

                // Create coverage details
                $coverageDetails = json_encode([
                    'copay' => rand(10, 50),
                    'coinsurance' => rand(10, 30) . '%',
                    'out_of_pocket_max' => rand(2000, 10000),
                    'prescription_coverage' => (bool) rand(0, 1),
                    'network_type' => ['PPO', 'HMO', 'EPO', 'POS'][array_rand(['PPO', 'HMO', 'EPO', 'POS'])],
                ]);

                // Create beneficiaries
                $beneficiaries = json_encode([
                    [
                        'name' => 'Primary Beneficiary',
                        'relationship' => ['Spouse', 'Child', 'Parent', 'Sibling'][array_rand(['Spouse', 'Child', 'Parent', 'Sibling'])],
                        'percentage' => 100
                    ]
                ]);

                // Create documents
                $documents = json_encode([
                    [
                        'name' => 'Policy Document',
                        'path' => 'documents/insurance/' . $user->id . '/policy.pdf'
                    ]
                ]);

                InsurancePlan::create([
                    'user_id' => $user->id,
                    'plan_name' => $provider . ' ' . $type . ' Plan',
                    'description' => 'Standard ' . $type . ' insurance plan provided by ' . $provider,
                    'type' => $type,
                    'provider' => $provider,
                    'policy_number' => 'POL-' . strtoupper(substr(md5(uniqid()), 0, 10)),
                    'coverage_details' => $coverageDetails,
                    'premium_amount' => $premiumAmount,
                    'deductible_amount' => $deductibleAmount,
                    'coverage_limit' => $coverageLimit,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'renewal_date' => $renewalDate,
                    'status' => $status,
                    'beneficiaries' => $beneficiaries,
                    'documents' => $documents,
                    'metadata' => json_encode([
                        'enrollment_date' => $startDate->format('Y-m-d'),
                        'has_dependents' => (bool) rand(0, 1)
                    ])
                ]);
            }
        }

        $this->command->info('Insurance plans seeded successfully!');
    }
}
