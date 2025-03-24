<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DepartmentService
{
    /**
     * The department repository instance.
     *
     * @var DepartmentRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param DepartmentRepositoryInterface $repository
     * @return void
     */
    public function __construct(DepartmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all departments.
     *
     * @return Collection
     */
    public function getAllDepartments(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Get department by ID.
     *
     * @param int $id
     * @return Department|null
     */
    public function getDepartmentById(int $id): ?Department
    {
        return $this->repository->findById($id);
    }

    /**
     * Create a new department.
     *
     * @param array $data
     * @return Department|null
     */
    public function createDepartment(array $data): ?Department
    {
        // Check if manager exists when provided
        if (isset($data['manager_id']) && !$this->repository->managerExists($data['manager_id'])) {
            return null;
        }

        return $this->repository->create($data);
    }

    /**
     * Update a department.
     *
     * @param int $id
     * @param array $data
     * @return Department|null
     */
    public function updateDepartment(int $id, array $data): ?Department
    {
        // Check if manager exists when provided
        if (isset($data['manager_id']) && !$this->repository->managerExists($data['manager_id'])) {
            return null;
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a department.
     *
     * @param int $id
     * @return bool
     */
    public function deleteDepartment(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
