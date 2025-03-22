<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\MonthlyPayroll;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonthlyPayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // First, check if we have users
        $users = User::all();
        if ($users->isEmpty()) {
            $this->command->info('No users found! Please run UserSeeder first.');
            return;
        }

        // Also check for departments
        $departments = Department::all();
        if ($departments->isEmpty()) {
            $this->command->info('No departments found! Please run DepartmentSeeder first.');
            return;
        }

        // Clear existing data
        DB::table('monthly_payrolls')->truncate();

        // Get random users for payrolls
        $employeeUsers = $users->where('role', 'employee')->values();
        $adminUsers = $users->where('role', 'admin')->values();

        if ($employeeUsers->isEmpty()) {
            $this->command->info('No employee users found! Using available users instead.');
            $employeeUsers = $users;
        }

        if ($adminUsers->isEmpty()) {
            $this->command->info('No admin users found! Using first user as admin for approvals.');
            $adminUsers = collect([$users->first()]);
        }

        $status = ['Pending', 'Approved', 'Paid', 'Cancelled'];
        $paymentMethods = ['Bank Transfer', 'Check', 'Cash', 'Digital Wallet'];

        // Current month and previous 2 months
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $monthsToSeed = [
            ['month' => $currentMonth, 'year' => $currentYear],
            ['month' => $currentMonth - 1 > 0 ? $currentMonth - 1 : 12, 'year' => $currentMonth - 1 > 0 ? $currentYear : $currentYear - 1],
            ['month' => $currentMonth - 2 > 0 ? $currentMonth - 2 : $currentMonth - 2 + 12, 'year' => $currentMonth - 2 > 0 ? $currentYear : $currentYear - 1],
        ];

        foreach ($employeeUsers as $employee) {
            // Get a random department
            $department = $departments->random();

            foreach ($monthsToSeed as $monthYear) {
                $month = $monthYear['month'];
                $year = $monthYear['year'];

                // Generate some variation in the salaries
                $basicSalary = mt_rand(3000, 8000);
                $allowances = mt_rand(300, 1000);
                $deductions = mt_rand(100, 500);
                $bonus = mt_rand(0, 1000);
                $overtimeHours = mt_rand(0, 20);
                $overtimeRate = 1.5 * ($basicSalary / 160); // assuming 160 working hours per month
                $overtimePay = $overtimeHours * $overtimeRate;
                $tax = 0.2 * $basicSalary; // 20% tax rate
                $grossSalary = $basicSalary + $allowances + $bonus + $overtimePay;
                $netSalary = $grossSalary - $deductions - $tax;

                // Generate a status based on the month/year
                // Current month is mostly Pending, previous month is Approved/Paid, older is mostly Paid
                $statusProbability = [];
                if ($month == $currentMonth && $year == $currentYear) {
                    $statusProbability = [0 => 70, 1 => 20, 2 => 5, 3 => 5]; // 70% Pending, 20% Approved, 5% Paid, 5% Cancelled
                } elseif (($month == $currentMonth - 1 && $year == $currentYear) ||
                         ($month == 12 && $currentMonth == 1 && $year == $currentYear - 1)) {
                    $statusProbability = [0 => 10, 1 => 50, 2 => 30, 3 => 10]; // 10% Pending, 50% Approved, 30% Paid, 10% Cancelled
                } else {
                    $statusProbability = [0 => 5, 1 => 15, 2 => 70, 3 => 10]; // 5% Pending, 15% Approved, 70% Paid, 10% Cancelled
                }

                $statusIndex = $this->getRandomWeightedIndex($statusProbability);
                $currentStatus = $status[$statusIndex];

                // Created by and approved by users (if applicable)
                $createdBy = $adminUsers->random()->id;
                $approvedBy = null;
                $approvedAt = null;
                if ($currentStatus != 'Pending') {
                    $approvedBy = $adminUsers->random()->id;
                    $approvedAt = now()->subDays(rand(1, 10));
                }

                // Payment details for paid payrolls
                $paymentDate = null;
                $paymentMethod = null;
                $paymentReference = null;
                if ($currentStatus == 'Paid') {
                    $paymentDate = now()->subDays(rand(1, 5));
                    $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                    $paymentReference = 'REF-' . strtoupper(substr(md5(rand()), 0, 10));
                }

                // Create sample benefit data
                $benefits = json_encode([
                    'health_insurance' => mt_rand(100, 300),
                    'dental_insurance' => mt_rand(50, 150),
                    'retirement_contribution' => mt_rand(200, 500),
                    'transportation' => mt_rand(50, 200)
                ]);

                // Create sample deduction details
                $deductionDetails = json_encode([
                    'income_tax' => $tax,
                    'retirement_deduction' => mt_rand(100, 300),
                    'health_insurance_deduction' => mt_rand(50, 200),
                    'other_deductions' => mt_rand(0, 100)
                ]);

                // Create sample allowance details
                $allowanceDetails = json_encode([
                    'transportation_allowance' => mt_rand(100, 300),
                    'meal_allowance' => mt_rand(50, 200),
                    'housing_allowance' => mt_rand(200, 500),
                    'phone_allowance' => mt_rand(50, 100)
                ]);

                // Create the payroll record
                MonthlyPayroll::create([
                    'user_id' => $employee->id,
                    'department_id' => $department->id,
                    'month' => $month,
                    'year' => $year,
                    'basic_salary' => $basicSalary,
                    'allowances' => $allowances,
                    'deductions' => $deductions,
                    'bonus' => $bonus,
                    'overtime_hours' => $overtimeHours,
                    'overtime_rate' => $overtimeRate,
                    'overtime_pay' => $overtimePay,
                    'tax' => $tax,
                    'net_salary' => $netSalary,
                    'gross_salary' => $grossSalary,
                    'benefits' => $benefits,
                    'deduction_details' => $deductionDetails,
                    'allowance_details' => $allowanceDetails,
                    'payment_date' => $paymentDate,
                    'payment_method' => $paymentMethod,
                    'payment_reference' => $paymentReference,
                    'status' => $currentStatus,
                    'notes' => $this->generateRandomNote($currentStatus),
                    'created_by' => $createdBy,
                    'approved_by' => $approvedBy,
                    'approved_at' => $approvedAt,
                    'metadata' => json_encode([
                        'payroll_reference' => 'PR-' . $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . $employee->id,
                        'processed_at' => now()->toDateTimeString(),
                        'generated_by' => 'Payroll System'
                    ])
                ]);
            }
        }

        $this->command->info('Monthly payrolls seeded successfully!');
    }

    /**
     * Get a random index based on weights
     *
     * @param array $weights
     * @return int
     */
    private function getRandomWeightedIndex(array $weights): int
    {
        $sum = array_sum($weights);
        $rand = mt_rand(1, $sum);

        foreach ($weights as $index => $weight) {
            $rand -= $weight;
            if ($rand <= 0) {
                return $index;
            }
        }

        return 0; // Fallback
    }

    /**
     * Generate a random note based on status
     *
     * @param string $status
     * @return string
     */
    private function generateRandomNote(string $status): string
    {
        $notes = [
            'Pending' => [
                'Awaiting manager approval',
                'Calculation complete, pending approval',
                'To be reviewed by finance department',
                'Verify overtime hours',
                'Check allowances calculation'
            ],
            'Approved' => [
                'Approved by finance manager',
                'All calculations verified',
                'Ready for payment processing',
                'Approved on schedule',
                'Verified and approved'
            ],
            'Paid' => [
                'Payment processed successfully',
                'Funds transferred to employee account',
                'Payment confirmation sent to employee',
                'Processed through accounting system',
                'Payment completed on schedule'
            ],
            'Cancelled' => [
                'Calculation error detected',
                'Employee status changed mid-month',
                'Administrative hold on payroll',
                'Recalculation required',
                'Cancelled at employee request'
            ]
        ];

        return $notes[$status][array_rand($notes[$status])];
    }
}
