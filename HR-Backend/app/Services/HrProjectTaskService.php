<?php

namespace App\Services;

use App\Models\HrProject;
use App\Models\HrProjectTask;
use App\Models\Task;
use App\Repositories\Interfaces\HrProjectTaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class HrProjectTaskService
{
    /**
     * The HR Project Task repository instance.
     *
     * @var HrProjectTaskRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param HrProjectTaskRepositoryInterface $repository
     * @return void
     */
    public function __construct(HrProjectTaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all project tasks with their relationships.
     *
     * @return Collection
     */
    public function getAllProjectTasks(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Get a specific project task by ID.
     *
     * @param int $id
     * @return HrProjectTask|null
     */
    public function getProjectTaskById(int $id): ?HrProjectTask
    {
        return $this->repository->findById($id);
    }

    /**
     * Create a new project task.
     *
     * @param array $data
     * @return HrProjectTask|null
     */
    public function createProjectTask(array $data): ?HrProjectTask
    {
        // Check if the relationship already exists
        if ($this->repository->exists($data['hr_project_id'], $data['task_id'])) {
            return null;
        }

        return $this->repository->create($data);
    }

    /**
     * Delete a project task.
     *
     * @param int $id
     * @return bool
     */
    public function deleteProjectTask(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get all tasks for a specific project.
     *
     * @param int $projectId
     * @return Collection|null
     */
    public function getTasksByProjectId(int $projectId): ?Collection
    {
        return $this->repository->getTasksByProjectId($projectId);
    }

    /**
     * Get all projects for a specific task.
     *
     * @param int $taskId
     * @return Collection|null
     */
    public function getProjectsByTaskId(int $taskId): ?Collection
    {
        return $this->repository->getProjectsByTaskId($taskId);
    }

    /**
     * Check if a project exists.
     *
     * @param int $projectId
     * @return bool
     */
    public function projectExists(int $projectId): bool
    {
        return $this->repository->projectExists($projectId);
    }

    /**
     * Check if a task exists.
     *
     * @param int $taskId
     * @return bool
     */
    public function taskExists(int $taskId): bool
    {
        return $this->repository->taskExists($taskId);
    }
}
