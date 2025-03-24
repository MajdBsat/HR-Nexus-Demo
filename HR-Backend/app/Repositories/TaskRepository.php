<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * Get all tasks.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Task::all();
    }

    /**
     * Find task by ID.
     *
     * @param int $id
     * @return Task|null
     */
    public function findById(int $id): ?Task
    {
        return Task::find($id);
    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Update an existing task.
     *
     * @param int $id
     * @param array $data
     * @return Task|null
     */
    public function update(int $id, array $data): ?Task
    {
        $task = $this->findById($id);

        if (!$task) {
            return null;
        }

        $task->update($data);
        return $task;
    }

    /**
     * Delete a task.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $task = $this->findById($id);

        if (!$task) {
            return false;
        }

        return $task->delete();
    }

    /**
     * Get tasks by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        return Task::where('status', $status)->get();
    }

    /**
     * Get tasks by priority.
     *
     * @param string $priority
     * @return Collection
     */
    public function getByPriority(string $priority): Collection
    {
        return Task::where('priority', $priority)->get();
    }

    /**
     * Get tasks by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return Task::where('assigned_to', $userId)->get();
    }

    /**
     * Get upcoming tasks.
     *
     * @param int $days
     * @return Collection
     */
    public function getUpcomingTasks(int $days = 7): Collection
    {
        $today = Carbon::now();
        $endDate = Carbon::now()->addDays($days);

        return Task::whereBetween('due_date', [$today, $endDate])
            ->orderBy('due_date')
            ->get();
    }

    /**
     * Check if a user exists.
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool
    {
        return User::where('id', $userId)->exists();
    }
}
