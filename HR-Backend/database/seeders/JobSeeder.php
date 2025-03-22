<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
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
        // Create sample jobs
        $jobs = [
            [
                'title' => 'HR Manager',
                'department' => 'Human Resources',
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
                'job_type' => 'Full-time',
                'job_level' => 'Senior',
                'salary_min' => 80000,
                'salary_max' => 110000,
                'salary_currency' => 'USD',
                'salary_period' => 'yearly',
                'is_remote' => false,
                'posting_date' => now(),
                'status' => 'Published',
                'vacancies' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Software Developer',
                'department' => 'Information Technology',
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
                'job_type' => 'Full-time',
                'job_level' => 'Mid',
                'salary_min' => 75000,
                'salary_max' => 120000,
                'salary_currency' => 'USD',
                'salary_period' => 'yearly',
                'is_remote' => true,
                'posting_date' => now(),
                'status' => 'Published',
                'vacancies' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Financial Analyst',
                'department' => 'Finance & Accounting',
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
                'job_type' => 'Full-time',
                'job_level' => 'Entry',
                'salary_min' => 65000,
                'salary_max' => 90000,
                'salary_currency' => 'USD',
                'salary_period' => 'yearly',
                'is_remote' => false,
                'posting_date' => now(),
                'status' => 'Published',
                'vacancies' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Marketing Coordinator',
                'department' => 'Marketing',
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
                'job_type' => 'Full-time',
                'job_level' => 'Entry',
                'salary_min' => 50000,
                'salary_max' => 70000,
                'salary_currency' => 'USD',
                'salary_period' => 'yearly',
                'is_remote' => false,
                'posting_date' => now(),
                'status' => 'Published',
                'vacancies' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Operations Manager',
                'department' => 'Operations',
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
                'job_type' => 'Full-time',
                'job_level' => 'Senior',
                'salary_min' => 85000,
                'salary_max' => 115000,
                'salary_currency' => 'USD',
                'salary_period' => 'yearly',
                'is_remote' => false,
                'posting_date' => now(),
                'status' => 'Published',
                'vacancies' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert the jobs
        DB::table('jobs')->insert($jobs);
    }
}
