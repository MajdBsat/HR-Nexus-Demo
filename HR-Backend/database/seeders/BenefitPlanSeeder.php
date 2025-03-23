<?php

namespace Database\Seeders;

use App\Models\BenefitPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BenefitPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $benefitPlans = [
            'Standard Employee Benefits Package',
            'Executive Benefits Package',
            'Remote Worker Benefits Package',
            'Entry-Level Benefits Package',
            'Part-Time Employee Benefits',
            'Senior Management Benefits',
            'International Employee Benefits'
        ];

        foreach ($benefitPlans as $planName) {
            BenefitPlan::create([
                'benefit_plan_name' => $planName
            ]);
        }

        $this->command->info('Benefit plans seeded successfully!');
    }
}
