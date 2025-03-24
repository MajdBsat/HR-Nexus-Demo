<?php

namespace App\Repositories\Interfaces;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

interface DepartmentRepositoryInterface
{
    /**
     * Get all departments.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get department by ID.
     *
     * @param int $id
     * @return Department|null
     */
    public function findById(int $id): ?Department;

    /**
     * Create a new department.
     *
     * @param array $data
     * @return Department
     */
    public function create(array $data): Department;

    /**
     * Update a department.
     *
     * @param int $id
     * @param array $data
     * @return Department|null
     */
    public function update(int $id, array $data): ?Department;

    /**
     * Delete a department.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Check if manager exists.
     *
     * @param int $managerId
     * @return bool
     */
    public function managerExists(int $managerId): bool;
}
