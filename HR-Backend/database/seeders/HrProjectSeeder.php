<?php

namespace Database\Seeders;

use App\Models\HrProject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HrProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some user IDs to associate with HR projects
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            // Create a user if none exists
            $user = User::factory()->create();
            $userIds = [$user->id];
        }

        // Sample HR projects data
        $hrProjects = [
            [
                'name' => 'Employee Onboarding System',
                'status' => 'in-progress',
                'priority' => 'high',
                'due_date' => now()->addMonths(2),
                'assigned_to' => $userIds[array_rand($userIds)],
                'description' => 'Design and implement a streamlined employee onboarding system to improve efficiency and new hire experience.',
                'metadata' => json_encode([
                    'budget' => 15000,
                    'team_size' => 4,
                    'stakeholders' => ['HR Director', 'IT Manager', 'CEO']
                ])
            ],
            [
                'name' => 'Performance Review Framework',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => now()->addMonths(3),
                'assigned_to' => $userIds[array_rand($userIds)],
                'description' => 'Develop a comprehensive performance review framework to standardize evaluation processes.',
                'metadata' => json_encode([
                    'budget' => 8000,
                    'team_size' => 2,
                    'stakeholders' => ['HR Manager', 'Department Heads']
                ])
            ],
            [
                'name' => 'Remote Work Policy Implementation',
                'status' => 'completed',
                'priority' => 'medium',
                'due_date' => now()->subMonths(1),
                'assigned_to' => $userIds[array_rand($userIds)],
                'description' => 'Create and roll out company-wide remote work policies and guidelines.',
                'metadata' => json_encode([
                    'budget' => 5000,
                    'team_size' => 3,
                    'stakeholders' => ['COO', 'HR Director', 'Legal Counsel']
                ])
            ],
            [
                'name' => 'Diversity and Inclusion Initiative',
                'status' => 'in-progress',
                'priority' => 'high',
                'due_date' => now()->addMonths(6),
                'assigned_to' => $userIds[array_rand($userIds)],
                'description' => 'Develop and implement company-wide diversity and inclusion programs.',
                'metadata' => json_encode([
                    'budget' => 25000,
                    'team_size' => 5,
                    'stakeholders' => ['CEO', 'HR Director', 'Department Heads', 'External Consultant']
                ])
            ],
            [
                'name' => 'Employee Wellness Program',
                'status' => 'on-hold',
                'priority' => 'low',
                'due_date' => now()->addMonths(4),
                'assigned_to' => $userIds[array_rand($userIds)],
                'description' => 'Design and implement a comprehensive employee wellness program to improve health and job satisfaction.',
                'metadata' => json_encode([
                    'budget' => 12000,
                    'team_size' => 2,
                    'stakeholders' => ['HR Manager', 'Benefits Coordinator']
                ])
            ],
            [
                'name' => 'HR System Migration',
                'status' => 'pending',
                'priority' => 'urgent',
                'due_date' => now()->addWeeks(6),
                'assigned_to' => $userIds[array_rand($userIds)],
                'description' => 'Migrate from legacy HR system to modern cloud-based HRIS platform.',
                'metadata' => json_encode([
                    'budget' => 50000,
                    'team_size' => 7,
                    'stakeholders' => ['CTO', 'HR Director', 'IT Team', 'Department Heads']
                ])
            ]
        ];

        // Insert the HR projects
        foreach ($hrProjects as $project) {
            HrProject::create($project);
        }
    }
}
