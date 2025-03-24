<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\User;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    /**
     * Get all departments.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Department::with('manager')->get();
    }

    /**
     * Get department by ID.
     *
     * @param int $id
     * @return Department|null
     */
    public function findById(int $id): ?Department
    {
        return Department::with('manager')->find($id);
    }

    /**
     * Create a new department.
     *
     * @param array $data
     * @return Department
     */
    public function create(array $data): Department
    {
        return Department::create($data);
    }

    /**
     * Update a department.
     *
     * @param int $id
     * @param array $data
     * @return Department|null
     */
    public function update(int $id, array $data): ?Department
    {
        $department = Department::find($id);

        if (!$department) {
            return null;
        }

        $department->update($data);

        return $department;
    }

    /**
     * Delete a department.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $department = Department::find($id);

        if (!$department) {
            return false;
        }

        return $department->delete();
    }

    /**
     * Check if manager exists.
     *
     * @param int $managerId
     * @return bool
     */
    public function managerExists(int $managerId): bool
    {
        return User::where('id', $managerId)->exists();
    }
}
