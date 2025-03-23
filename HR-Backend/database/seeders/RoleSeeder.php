<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'title' => 'HR Manager',
                'description' => 'Oversees all HR functions and personnel management across the organization.',
                'requirements' => 'Bachelor\'s degree in HR or related field, 5+ years of HR experience, excellent leadership skills, knowledge of employment laws and regulations.'
            ],
            [
                'title' => 'Software Developer',
                'description' => 'Designs, codes, tests, and maintains software applications according to specifications.',
                'requirements' => 'Bachelor\'s degree in Computer Science or related field, proficiency in programming languages, problem-solving skills, teamwork abilities.'
            ],
            [
                'title' => 'Financial Analyst',
                'description' => 'Analyzes financial data, prepares reports, and provides recommendations for financial planning.',
                'requirements' => 'Bachelor\'s degree in Finance or related field, analytical skills, proficiency in financial modeling, attention to detail.'
            ],
            [
                'title' => 'Marketing Specialist',
                'description' => 'Develops and implements marketing strategies to promote products, services, or the company brand.',
                'requirements' => 'Bachelor\'s degree in Marketing or related field, creativity, communication skills, market research abilities, social media expertise.'
            ],
            [
                'title' => 'Operations Manager',
                'description' => 'Oversees day-to-day operations, ensuring efficiency, quality, and compliance with company policies.',
                'requirements' => 'Bachelor\'s degree in Business or related field, leadership experience, organizational skills, problem-solving abilities, operational knowledge.'
            ],
            [
                'title' => 'Customer Service Representative',
                'description' => 'Assists customers by providing information, resolving issues, and ensuring satisfaction.',
                'requirements' => 'High school diploma or equivalent, excellent communication skills, problem-solving abilities, patience, customer service experience.'
            ],
            [
                'title' => 'Project Manager',
                'description' => 'Plans, executes, and closes projects while ensuring they are completed on time, within budget, and to specifications.',
                'requirements' => 'Bachelor\'s degree in Business or related field, PMP certification preferred, leadership skills, organizational abilities, risk management knowledge.'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->command->info('Roles seeded successfully!');
    }
}
