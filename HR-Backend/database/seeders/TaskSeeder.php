<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some user IDs to associate with tasks
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            // Create a user if none exists
            $user = User::factory()->create();
            $userIds = [$user->id];
        }

        // Sample tasks data
        $tasks = [
            [
                'title' => 'Create onboarding documents',
                'description' => 'Prepare welcome kit, handbook, and first-day orientation materials',
                'status' => 'completed',
                'priority' => 'high',
                'assigned_to' => $userIds[array_rand($userIds)],
                'due_date' => now()->subDays(15),
                'estimated_hours' => 8,
                'actual_hours' => 10
            ],
            [
                'title' => 'Update employee handbook',
                'description' => 'Revise remote work policies and incorporate new benefits information',
                'status' => 'in-progress',
                'priority' => 'medium',
                'assigned_to' => $userIds[array_rand($userIds)],
                'due_date' => now()->addDays(10),
                'estimated_hours' => 12,
                'actual_hours' => 6
            ],
            [
                'title' => 'Design diversity training workshop',
                'description' => 'Create curriculum and materials for quarterly diversity training sessions',
                'status' => 'pending',
                'priority' => 'high',
                'assigned_to' => $userIds[array_rand($userIds)],
                'due_date' => now()->addDays(20),
                'estimated_hours' => 16,
                'actual_hours' => 0
            ],
            [
                'title' => 'Review salary benchmarks',
                'description' => 'Analyze industry compensation data and prepare report for leadership team',
                'status' => 'in-progress',
                'priority' => 'medium',
                'assigned_to' => $userIds[array_rand($userIds)],
                'due_date' => now()->addDays(5),
                'estimated_hours' => 6,
                'actual_hours' => 4
            ],
            [
                'title' => 'Configure new HRIS system',
                'description' => 'Set up user roles, data migration plan, and integration with payroll software',
                'status' => 'pending',
                'priority' => 'urgent',
                'assigned_to' => $userIds[array_rand($userIds)],
                'due_date' => now()->addDays(3),
                'estimated_hours' => 24,
                'actual_hours' => 0
            ],
            [
                'title' => 'Conduct wellness program survey',
                'description' => 'Create and distribute employee survey about wellness program preferences',
                'status' => 'completed',
                'priority' => 'low',
                'assigned_to' => $userIds[array_rand($userIds)],
                'due_date' => now()->subDays(5),
                'estimated_hours' => 4,
                'actual_hours' => 3
            ],
            [
                'title' => 'Schedule performance reviews',
                'description' => 'Coordinate calendar for Q2 performance reviews with all department heads',
                'status' => 'pending',
                'priority' => 'medium',
                'assigned_to' => $userIds[array_rand($userIds)],
                'due_date' => now()->addDays(7),
                'estimated_hours' => 2,
                'actual_hours' => 0
            ]
        ];

        // Insert the tasks
        foreach ($tasks as $taskData) {
            Task::create($taskData);
        }
    }
}
