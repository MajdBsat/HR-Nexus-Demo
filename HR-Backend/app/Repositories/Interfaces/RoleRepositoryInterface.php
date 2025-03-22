<?php

namespace App\Repositories\Interfaces;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    /**
     * Get all roles.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find role by ID.
     *
     * @param int $id
     * @return Role|null
     */
    public function findById(int $id): ?Role;

    /**
     * Create a new role.
     *
     * @param array $data
     * @return Role
     */
    public function create(array $data): Role;

    /**
     * Update an existing role.
     *
     * @param int $id
     * @param array $data
     * @return Role|null
     */
    public function update(int $id, array $data): ?Role;

    /**
     * Delete a role.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Check if role has any associated onboarding tasks.
     *
     * @param int $id
     * @return bool
     */
    public function hasOnboardingTasks(int $id): bool;

    /**
     * Get all tasks associated with a role.
     *
     * @param int $roleId
     * @return Collection
     */
    public function getTasks(int $roleId): Collection;
}
