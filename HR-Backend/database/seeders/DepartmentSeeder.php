<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create sample departments
        $departments = [
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Responsible for recruiting, onboarding, training, and employee relations',
                'is_active' => true,
                'budget' => 250000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Information Technology',
                'code' => 'IT',
                'description' => 'Responsible for managing technology infrastructure and software systems',
                'is_active' => true,
                'budget' => 500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Finance & Accounting',
                'code' => 'FIN',
                'description' => 'Responsible for managing company finances, budgeting, and financial reporting',
                'is_active' => true,
                'budget' => 300000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marketing',
                'code' => 'MKT',
                'description' => 'Responsible for brand management, advertising, and market research',
                'is_active' => true,
                'budget' => 400000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Operations',
                'code' => 'OPS',
                'description' => 'Responsible for day-to-day operational activities',
                'is_active' => true,
                'budget' => 350000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert the departments
        DB::table('departments')->insert($departments);
    }
}
