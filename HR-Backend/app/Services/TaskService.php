<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class TaskService
{
    /**
     * The task repository instance.
     *
     * @var TaskRepositoryInterface
     */
    protected $taskRepository;

    /**
     * Create a new service instance.
     *
     * @param TaskRepositoryInterface $taskRepository
     * @return void
     */
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Get all tasks.
     *
     * @return Collection
     */
    public function getAllTasks(): Collection
    {
        return $this->taskRepository->getAll();
    }

    /**
     * Get task by ID.
     *
     * @param int $id
     * @return Task|null
     */
    public function getTaskById(int $id): ?Task
    {
        return $this->taskRepository->findById($id);
    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return array
     */
    public function createTask(array $data): array
    {
        // Validate data
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'due_date' => 'required|date',
            'assigned_to' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ];
        }

        // Check if assigned user exists
        if (isset($data['assigned_to']) && !$this->taskRepository->userExists($data['assigned_to'])) {
            return [
                'success' => false,
                'message' => 'Assigned user not found'
            ];
        }

        $task = $this->taskRepository->create($data);

        return [
            'success' => true,
            'message' => 'Task created successfully',
            'data' => $task
        ];
    }

    /**
     * Update an existing task.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateTask(int $id, array $data): array
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        // Validate data
        $validator = Validator::make($data, [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|string|in:pending,in_progress,completed,cancelled',
            'priority' => 'sometimes|required|string|in:low,medium,high,urgent',
            'due_date' => 'sometimes|required|date',
            'assigned_to' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ];
        }

        // Check if assigned user exists
        if (isset($data['assigned_to']) && !$this->taskRepository->userExists($data['assigned_to'])) {
            return [
                'success' => false,
                'message' => 'Assigned user not found'
            ];
        }

        $updatedTask = $this->taskRepository->update($id, $data);

        return [
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $updatedTask
        ];
    }

    /**
     * Delete a task.
     *
     * @param int $id
     * @return array
     */
    public function deleteTask(int $id): array
    {
        $task = $this->taskRepository->findById($id);

        if (!$task) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        $this->taskRepository->delete($id);

        return [
            'success' => true,
            'message' => 'Task deleted successfully'
        ];
    }

    /**
     * Get tasks by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getTasksByStatus(string $status): Collection
    {
        return $this->taskRepository->getByStatus($status);
    }

    /**
     * Get tasks by priority.
     *
     * @param string $priority
     * @return Collection
     */
    public function getTasksByPriority(string $priority): Collection
    {
        return $this->taskRepository->getByPriority($priority);
    }

    /**
     * Get tasks by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getTasksByUserId(int $userId): array
    {
        if (!$this->taskRepository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $tasks = $this->taskRepository->getByUserId($userId);

        return [
            'success' => true,
            'data' => $tasks
        ];
    }

    /**
     * Get upcoming tasks.
     *
     * @param int $days
     * @return Collection
     */
    public function getUpcomingTasks(int $days = 7): Collection
    {
        return $this->taskRepository->getUpcomingTasks($days);
    }
}
