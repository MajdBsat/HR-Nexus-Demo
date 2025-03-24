<?php

namespace App\Repositories\Interfaces;

use App\Models\BaseSalary;
use Illuminate\Database\Eloquent\Collection;

interface BaseSalaryRepositoryInterface
{
    /**
     * Get all base salary records.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get base salary record by ID.
     *
     * @param int $id
     * @return BaseSalary|null
     */
    public function findById(int $id): ?BaseSalary;

    /**
     * Create a new base salary record.
     *
     * @param array $data
     * @return BaseSalary
     */
    public function create(array $data): BaseSalary;

    /**
     * Update a base salary record.
     *
     * @param int $id
     * @param array $data
     * @return BaseSalary|null
     */
    public function update(int $id, array $data): ?BaseSalary;

    /**
     * Delete a base salary record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get base salary record by user ID.
     *
     * @param int $userId
     * @return BaseSalary|null
     */
    public function findByUserId(int $userId): ?BaseSalary;

    /**
     * Check if user exists.
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool;
}
