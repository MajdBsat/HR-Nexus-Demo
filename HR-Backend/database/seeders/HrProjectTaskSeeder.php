<?php

namespace Database\Seeders;

use App\Models\HrProject;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HrProjectTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = HrProject::all();
        $tasks = Task::all();

        if ($projects->isEmpty()) {
            $this->command->info('No HR projects found to associate tasks with!');
            return;
        }

        if ($tasks->isEmpty()) {
            $this->command->info('No tasks found to associate with HR projects!');
            return;
        }

        // For each project, assign 2-5 tasks
        foreach ($projects as $project) {
            // Determine number of tasks to associate
            $numTasks = rand(2, 5);

            // Get random tasks
            $selectedTasks = $tasks->random(min($numTasks, $tasks->count()));

            foreach ($selectedTasks as $task) {
                // Avoid duplicate entries
                $exists = DB::table('hr_project_tasks')
                    ->where('hr_project_id', $project->id)
                    ->where('task_id', $task->id)
                    ->exists();

                if (!$exists) {
                    DB::table('hr_project_tasks')->insert([
                        'hr_project_id' => $project->id,
                        'task_id' => $task->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        $this->command->info('HR project tasks seeded successfully!');
    }
}
