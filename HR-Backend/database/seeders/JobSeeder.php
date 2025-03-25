<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get department IDs by name
        $departments = Department::all()->pluck('id', 'name')->toArray();

        // Default department ID if not found
        $defaultDepartmentId = 1;

        // Create sample jobs
        $jobs = [
            [
                'title' => 'HR Manager',
                'department_id' => $departments['Human Resources'] ?? $defaultDepartmentId,
                'description' => 'Oversee all aspects of human resources operations within the company',
                'requirements' => json_encode([
                    'Bachelor\'s degree in HR or related field',
                    '5+ years experience in HR management',
                    'SHRM certification preferred'
                ]),
                'responsibilities' => json_encode([
                    'Develop HR policies and procedures',
                    'Oversee recruitment and hiring processes',
                    'Manage employee relations and benefits'
                ]),
                'location' => 'New York, NY',
                'employment_type' => 'full-time',
                'experience_years_min' => 5,
                'salary_min' => 80000,
                'salary_max' => 110000,
                'remote_eligible' => false,
                'posting_date' => now(),
                'status' => 'open',
                'positions_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Software Developer',
                'department_id' => $departments['Information Technology'] ?? $defaultDepartmentId,
                'description' => 'Develop and maintain software applications for internal and external use',
                'requirements' => json_encode([
                    'Bachelor\'s degree in CS or related field',
                    '3+ years experience in software development',
                    'Proficiency in PHP, JavaScript, and SQL'
                ]),
                'responsibilities' => json_encode([
                    'Design and implement software solutions',
                    'Write clean, maintainable code',
                    'Collaborate with cross-functional teams'
                ]),
                'location' => 'Remote',
                'employment_type' => 'full-time',
                'experience_years_min' => 3,
                'salary_min' => 75000,
                'salary_max' => 120000,
                'remote_eligible' => true,
                'posting_date' => now(),
                'status' => 'open',
                'positions_available' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Financial Analyst',
                'department_id' => $departments['Finance'] ?? $defaultDepartmentId,
                'description' => 'Analyze financial data and provide insights for business decisions',
                'requirements' => json_encode([
                    'Bachelor\'s degree in Finance or Accounting',
                    '2+ years experience in financial analysis',
                    'Strong Excel and data analysis skills'
                ]),
                'responsibilities' => json_encode([
                    'Prepare financial reports and forecasts',
                    'Analyze budget variances',
                    'Support budget planning process'
                ]),
                'location' => 'Chicago, IL',
                'employment_type' => 'full-time',
                'experience_years_min' => 2,
                'salary_min' => 65000,
                'salary_max' => 90000,
                'remote_eligible' => false,
                'posting_date' => now(),
                'status' => 'open',
                'positions_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Marketing Coordinator',
                'department_id' => $departments['Marketing'] ?? $defaultDepartmentId,
                'description' => 'Coordinate marketing campaigns and support marketing team activities',
                'requirements' => json_encode([
                    'Bachelor\'s degree in Marketing or Communications',
                    '1-3 years experience in marketing',
                    'Experience with social media platforms'
                ]),
                'responsibilities' => json_encode([
                    'Assist in campaign planning and execution',
                    'Create and schedule social media content',
                    'Track marketing metrics and report results'
                ]),
                'location' => 'Austin, TX',
                'employment_type' => 'full-time',
                'experience_years_min' => 1,
                'salary_min' => 50000,
                'salary_max' => 70000,
                'remote_eligible' => false,
                'posting_date' => now(),
                'status' => 'open',
                'positions_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Operations Manager',
                'department_id' => $departments['Operations'] ?? $defaultDepartmentId,
                'description' => 'Oversee daily operations and ensure efficient business processes',
                'requirements' => json_encode([
                    'Bachelor\'s degree in Business Administration or related field',
                    '5+ years experience in operations management',
                    'Strong leadership and problem-solving skills'
                ]),
                'responsibilities' => json_encode([
                    'Manage daily operations and workflow',
                    'Develop and implement operational strategies',
                    'Monitor performance metrics and suggest improvements'
                ]),
                'location' => 'Denver, CO',
                'employment_type' => 'full-time',
                'experience_years_min' => 5,
                'salary_min' => 85000,
                'salary_max' => 115000,
                'remote_eligible' => false,
                'posting_date' => now(),
                'status' => 'open',
                'positions_available' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert the jobs
        foreach ($jobs as $job) {
            Job::create($job);
        }
    }
}
