<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Information Technology',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Finance',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Marketing',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Sales',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Operations',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Customer Support',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Research & Development',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            // Insert departments
            Department::insert($departments);
        }
    }
}
