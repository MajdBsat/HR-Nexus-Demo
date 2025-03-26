<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    /**
     * Get all tasks.
     *
     * @return Collection
     */
    static public function getAll(): Collection;

    /**
     * Find task by ID.
     *
     * @param int $id
     * @return Task|null
     */
    static public function findById(int $id): ?Task;

    /**
     * Create a new task.
     *
     * @param array $data
     * @return Task
     */
    static public function create(array $data): Task;

    /**
     * Update an existing task.
     *
     * @param int $id
     * @param array $data
     * @return Task|null
     */
    static public function update(int $id, array $data): ?Task;

    /**
     * Delete a task.
     *
     * @param int $id
     * @return bool
     */
    static public function delete(int $id): bool;

    /**
     * Get tasks by status.
     *
     * @param string $status
     * @return Collection
     */
    static public function getByStatus(string $status): Collection;

    /**
     * Get tasks by priority.
     *
     * @param string $priority
     * @return Collection
     */
    static public function getByPriority(string $priority): Collection;

    /**
     * Get tasks by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    static public function getByUserId(int $userId): Collection;

    /**
     * Get upcoming tasks.
     *
     * @param int $days
     * @return Collection
     */
    static public function getUpcomingTasks(int $days = 7): Collection;

    /**
     * Check if a user exists.
     *
     * @param int $userId
     * @return bool
     */
    static public function userExists(int $userId): bool;
}
