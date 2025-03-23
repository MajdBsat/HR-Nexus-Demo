<?php

namespace Database\Seeders;

use App\Models\BaseSalary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BaseSalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found to attach base salary records!');
            return;
        }

        $salaryRanges = [
            'Junior' => [35000, 55000],
            'Mid-level' => [55000, 85000],
            'Senior' => [85000, 120000],
            'Lead' => [100000, 140000],
            'Manager' => [110000, 160000],
            'Director' => [140000, 220000],
            'Executive' => [180000, 300000],
        ];

        $bonusPercentages = [0, 5, 8, 10, 12, 15, 20];

        foreach ($users as $user) {
            // Randomly assign a level
            $level = array_rand($salaryRanges);

            // Generate base salary within the range for the level
            $baseSalary = rand($salaryRanges[$level][0], $salaryRanges[$level][1]);

            // Generate fixed bonus as a percentage of base salary
            $bonusPercentage = $bonusPercentages[array_rand($bonusPercentages)];
            $fixedBonus = ($baseSalary * $bonusPercentage) / 100;

            // Create effective date (between 1-3 years ago)
            $effectiveDate = Carbon::now()->subDays(rand(365, 365 * 3));

            BaseSalary::create([
                'user_id' => $user->id,
                'salary' => $baseSalary,
                'fixed_bonus' => $fixedBonus,
                'effective_date' => $effectiveDate->format('Y-m-d'),
            ]);
        }

        $this->command->info('Base salary records seeded successfully!');
    }
}
