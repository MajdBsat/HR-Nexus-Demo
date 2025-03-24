<?php

namespace App\Repositories\Interfaces;

use App\Models\OnboardingTask;
use App\Models\Role;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface OnboardingTaskRepositoryInterface
{
    /**
     * Get all onboarding tasks.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find an onboarding task by ID.
     *
     * @param int $id
     * @return OnboardingTask|null
     */
    public function findById(int $id): ?OnboardingTask;

    /**
     * Create a new onboarding task.
     *
     * @param array $data
     * @return OnboardingTask
     */
    public function create(array $data): OnboardingTask;

    /**
     * Update an onboarding task.
     *
     * @param int $id
     * @param array $data
     * @return OnboardingTask|null
     */
    public function update(int $id, array $data): ?OnboardingTask;

    /**
     * Delete an onboarding task.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get onboarding tasks by employee ID.
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getByEmployeeId(int $employeeId): Collection;

    /**
     * Get onboarding tasks by role ID.
     *
     * @param int $roleId
     * @return Collection
     */
    public function getByRoleId(int $roleId): Collection;

    /**
     * Get all roles.
     *
     * @return Collection
     */
    public function getAllRoles(): Collection;

    /**
     * Get role by ID.
     *
     * @param int $id
     * @return Role|null
     */
    public function getRoleById(int $id): ?Role;

    /**
     * Create a new role.
     *
     * @param array $data
     * @return Role
     */
    public function createRole(array $data): Role;

    /**
     * Update a role.
     *
     * @param int $id
     * @param array $data
     * @return Role|null
     */
    public function updateRole(int $id, array $data): ?Role;

    /**
     * Delete a role.
     *
     * @param int $id
     * @return bool
     */
    public function deleteRole(int $id): bool;

    /**
     * Get all tasks for a specific role.
     *
     * @param int $roleId
     * @return Collection
     */
    public function getTasksByRoleId(int $roleId): Collection;

    /**
     * Assign a task to a role.
     *
     * @param int $roleId
     * @param int $taskId
     * @return bool
     */
    public function assignTaskToRole(int $roleId, int $taskId): bool;

    /**
     * Remove a task from a role.
     *
     * @param int $roleId
     * @param int $taskId
     * @return bool
     */
    public function removeTaskFromRole(int $roleId, int $taskId): bool;

    /**
     * Check if an employee exists.
     *
     * @param int $employeeId
     * @return bool
     */
    public function employeeExists(int $employeeId): bool;

    /**
     * Check if a role exists.
     *
     * @param int $roleId
     * @return bool
     */
    public function roleExists(int $roleId): bool;

    /**
     * Check if a task exists.
     *
     * @param int $taskId
     * @return bool
     */
    public function taskExists(int $taskId): bool;
}
