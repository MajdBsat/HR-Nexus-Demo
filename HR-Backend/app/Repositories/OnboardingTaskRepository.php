<?php

namespace App\Repositories;

use App\Models\OnboardingTask;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Interfaces\OnboardingTaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OnboardingTaskRepository implements OnboardingTaskRepositoryInterface
{
    /**
     * Get all onboarding tasks.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return OnboardingTask::all();
    }

    /**
     * Find an onboarding task by ID.
     *
     * @param int $id
     * @return OnboardingTask|null
     */
    public function findById(int $id): ?OnboardingTask
    {
        return OnboardingTask::find($id);
    }

    /**
     * Create a new onboarding task.
     *
     * @param array $data
     * @return OnboardingTask
     */
    public function create(array $data): OnboardingTask
    {
        return OnboardingTask::create($data);
    }

    /**
     * Update an onboarding task.
     *
     * @param int $id
     * @param array $data
     * @return OnboardingTask|null
     */
    public function update(int $id, array $data): ?OnboardingTask
    {
        $onboardingTask = $this->findById($id);

        if ($onboardingTask) {
            $onboardingTask->update($data);
            return $onboardingTask;
        }

        return null;
    }

    /**
     * Delete an onboarding task.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $onboardingTask = $this->findById($id);

        if ($onboardingTask) {
            return $onboardingTask->delete();
        }

        return false;
    }

    /**
     * Get onboarding tasks by employee ID.
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getByEmployeeId(int $employeeId): Collection
    {
        return OnboardingTask::where('employee_id', $employeeId)->get();
    }

    /**
     * Get onboarding tasks by role ID.
     *
     * @param int $roleId
     * @return Collection
     */
    public function getByRoleId(int $roleId): Collection
    {
        return OnboardingTask::where('role_id', $roleId)->get();
    }

    /**
     * Get all roles.
     *
     * @return Collection
     */
    public function getAllRoles(): Collection
    {
        return Role::all();
    }

    /**
     * Get role by ID.
     *
     * @param int $id
     * @return Role|null
     */
    public function getRoleById(int $id): ?Role
    {
        return Role::find($id);
    }

    /**
     * Create a new role.
     *
     * @param array $data
     * @return Role
     */
    public function createRole(array $data): Role
    {
        return Role::create($data);
    }

    /**
     * Update a role.
     *
     * @param int $id
     * @param array $data
     * @return Role|null
     */
    public function updateRole(int $id, array $data): ?Role
    {
        $role = $this->getRoleById($id);

        if ($role) {
            $role->update($data);
            return $role;
        }

        return null;
    }

    /**
     * Delete a role.
     *
     * @param int $id
     * @return bool
     */
    public function deleteRole(int $id): bool
    {
        $role = $this->getRoleById($id);

        if ($role) {
            return $role->delete();
        }

        return false;
    }

    /**
     * Get all tasks for a specific role.
     *
     * @param int $roleId
     * @return Collection
     */
    public function getTasksByRoleId(int $roleId): Collection
    {
        $roleTasks = OnboardingTask::where('role_id', $roleId)
            ->pluck('task_id')
            ->toArray();

        return Task::whereIn('id', $roleTasks)->get();
    }

    /**
     * Assign a task to a role.
     *
     * @param int $roleId
     * @param int $taskId
     * @return bool
     */
    public function assignTaskToRole(int $roleId, int $taskId): bool
    {
        // Check if the role-task assignment already exists
        $exists = OnboardingTask::where('role_id', $roleId)
            ->where('task_id', $taskId)
            ->exists();

        if (!$exists) {
            OnboardingTask::create([
                'role_id' => $roleId,
                'task_id' => $taskId,
                'employee_id' => null // This is a template, not assigned to any employee yet
            ]);
            return true;
        }

        return false;
    }

    /**
     * Remove a task from a role.
     *
     * @param int $roleId
     * @param int $taskId
     * @return bool
     */
    public function removeTaskFromRole(int $roleId, int $taskId): bool
    {
        // Only delete template tasks (where employee_id is null)
        return OnboardingTask::where('role_id', $roleId)
            ->where('task_id', $taskId)
            ->whereNull('employee_id')
            ->delete() > 0;
    }

    /**
     * Check if an employee exists.
     *
     * @param int $employeeId
     * @return bool
     */
    public function employeeExists(int $employeeId): bool
    {
        return User::where('id', $employeeId)->exists();
    }

    /**
     * Check if a role exists.
     *
     * @param int $roleId
     * @return bool
     */
    public function roleExists(int $roleId): bool
    {
        return Role::where('id', $roleId)->exists();
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
