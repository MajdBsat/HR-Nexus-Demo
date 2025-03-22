<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Task;
use App\Models\OnboardingTask;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * Get all roles.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Role::all();
    }

    /**
     * Find role by ID.
     *
     * @param int $id
     * @return Role|null
     */
    public function findById(int $id): ?Role
    {
        return Role::find($id);
    }

    /**
     * Create a new role.
     *
     * @param array $data
     * @return Role
     */
    public function create(array $data): Role
    {
        return Role::create($data);
    }

    /**
     * Update an existing role.
     *
     * @param int $id
     * @param array $data
     * @return Role|null
     */
    public function update(int $id, array $data): ?Role
    {
        $role = $this->findById($id);

        if (!$role) {
            return null;
        }

        $role->update($data);
        return $role;
    }

    /**
     * Delete a role.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $role = $this->findById($id);

        if (!$role) {
            return false;
        }

        if ($this->hasOnboardingTasks($id)) {
            return false;
        }

        return $role->delete();
    }

    /**
     * Check if role has any associated onboarding tasks.
     *
     * @param int $id
     * @return bool
     */
    public function hasOnboardingTasks(int $id): bool
    {
        return OnboardingTask::where('role_id', $id)->exists();
    }

    /**
     * Get all tasks associated with a role.
     *
     * @param int $roleId
     * @return Collection
     */
    public function getTasks(int $roleId): Collection
    {
        // Get all tasks associated with this role through onboarding tasks
        $taskIds = OnboardingTask::where('role_id', $roleId)
            ->whereNull('employee_id') // Get only template tasks, not employee-specific ones
            ->pluck('task_id')
            ->unique();

        return Task::whereIn('id', $taskIds)->get();
    }
}
