<?php

namespace App\Repositories\Interfaces;

use App\Models\HrProjectTask;
use Illuminate\Database\Eloquent\Collection;

interface HrProjectTaskRepositoryInterface
{
    /**
     * Get all project tasks with their relationships.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get a specific project task by ID.
     *
     * @param int $id
     * @return HrProjectTask|null
     */
    public function findById(int $id): ?HrProjectTask;

    /**
     * Check if a project task relationship exists.
     *
     * @param int $projectId
     * @param int $taskId
     * @return bool
     */
    public function exists(int $projectId, int $taskId): bool;

    /**
     * Create a new project task.
     *
     * @param array $data
     * @return HrProjectTask
     */
    public function create(array $data): HrProjectTask;

    /**
     * Delete a project task.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get all tasks for a specific project.
     *
     * @param int $projectId
     * @return Collection|null
     */
    public function getTasksByProjectId(int $projectId): ?Collection;

    /**
     * Get all projects for a specific task.
     *
     * @param int $taskId
     * @return Collection|null
     */
    public function getProjectsByTaskId(int $taskId): ?Collection;

    /**
     * Check if a project exists.
     *
     * @param int $projectId
     * @return bool
     */
    public function projectExists(int $projectId): bool;

    /**
     * Check if a task exists.
     *
     * @param int $taskId
     * @return bool
     */
    public function taskExists(int $taskId): bool;
}
