<?php

namespace App\Repositories;

use App\Models\HrProject;
use App\Models\HrProjectTask;
use App\Models\Task;
use App\Repositories\Interfaces\HrProjectTaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class HrProjectTaskRepository implements HrProjectTaskRepositoryInterface
{
    /**
     * Get all project tasks with their relationships.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return HrProjectTask::with(['hrProject', 'task'])->get();
    }

    /**
     * Get a specific project task by ID.
     *
     * @param int $id
     * @return HrProjectTask|null
     */
    public function findById(int $id): ?HrProjectTask
    {
        return HrProjectTask::with(['hrProject', 'task'])->find($id);
    }

    /**
     * Check if a project task relationship exists.
     *
     * @param int $projectId
     * @param int $taskId
     * @return bool
     */
    public function exists(int $projectId, int $taskId): bool
    {
        return HrProjectTask::where('hr_project_id', $projectId)
            ->where('task_id', $taskId)
            ->exists();
    }

    /**
     * Create a new project task.
     *
     * @param array $data
     * @return HrProjectTask
     */
    public function create(array $data): HrProjectTask
    {
        return HrProjectTask::create($data);
    }

    /**
     * Delete a project task.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $projectTask = HrProjectTask::find($id);

        if (!$projectTask) {
            return false;
        }

        return $projectTask->delete();
    }

    /**
     * Get all tasks for a specific project.
     *
     * @param int $projectId
     * @return Collection|null
     */
    public function getTasksByProjectId(int $projectId): ?Collection
    {
        $project = HrProject::find($projectId);

        if (!$project) {
            return null;
        }

        return $project->tasks;
    }

    /**
     * Get all projects for a specific task.
     *
     * @param int $taskId
     * @return Collection|null
     */
    public function getProjectsByTaskId(int $taskId): ?Collection
    {
        $task = Task::find($taskId);

        if (!$task) {
            return null;
        }

        return $task->hrProjects;
    }

    /**
     * Check if a project exists.
     *
     * @param int $projectId
     * @return bool
     */
    public function projectExists(int $projectId): bool
    {
        return HrProject::where('id', $projectId)->exists();
    }

    /**
     * Check if a task exists.
     *
     * @param int $taskId
     * @return bool
     */
    public function taskExists(int $taskId): bool
    {
        return Task::where('id', $taskId)->exists();
    }
}
