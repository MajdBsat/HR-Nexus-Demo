<?php

namespace Database\Seeders;

use App\Models\OnboardingTask;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OnboardingTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $roles = Role::all();
        $tasks = Task::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found to create onboarding tasks!');
            return;
        }

        if ($roles->isEmpty()) {
            $this->command->info('No roles found to create onboarding tasks!');
            return;
        }

        if ($tasks->isEmpty()) {
            $this->command->info('No tasks found to create onboarding tasks!');
            return;
        }

        // For each user, assign 3-5 onboarding tasks related to a randomly assigned role
        foreach ($users as $user) {
            // Randomly assign a role to the user for onboarding
            $role = $roles->random();

            // Shuffle tasks and select 3-5 random tasks
            $shuffledTasks = $tasks->shuffle()->take(rand(3, 5));

            foreach ($shuffledTasks as $task) {
                OnboardingTask::create([
                    'employee_id' => $user->id,
                    'role_id' => $role->id,
                    'task_id' => $task->id,
                ]);
            }
        }

        $this->command->info('Onboarding tasks seeded successfully!');
    }
}
