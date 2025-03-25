<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only seed if departments table is empty
        if (Department::count() === 0) {
            // Create the departments
            $departments = [
                [
                    'name' => 'Human Resources',
                    'code' => 'HR',
                    'description' => 'Handles employee relations, recruitment, and workforce management',
                    'is_active' => true,
                    'budget' => 250000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Information Technology',
                    'code' => 'IT',
                    'description' => 'Manages technology infrastructure and software development',
                    'is_active' => true,
                    'budget' => 500000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Finance',
                    'code' => 'FIN',
                    'description' => 'Handles company finances, budgeting, and accounting',
                    'is_active' => true,
                    'budget' => 300000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Marketing',
                    'code' => 'MKT',
                    'description' => 'Responsible for company promotion and brand management',
                    'is_active' => true,
                    'budget' => 400000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Sales',
                    'code' => 'SLS',
                    'description' => 'Manages customer relationships and revenue generation',
                    'is_active' => true,
                    'budget' => 450000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Operations',
                    'code' => 'OPS',
                    'description' => 'Oversees day-to-day business operations and logistics',
                    'is_active' => true,
                    'budget' => 350000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Customer Support',
                    'code' => 'CS',
                    'description' => 'Handles customer inquiries and provides technical assistance',
                    'is_active' => true,
                    'budget' => 200000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Research & Development',
                    'code' => 'R&D',
                    'description' => 'Focuses on innovation and development of new products',
                    'is_active' => true,
                    'budget' => 600000,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            // Insert departments
            Department::insert($departments);
        }
    }
}
