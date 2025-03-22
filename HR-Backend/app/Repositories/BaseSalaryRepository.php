<?php

namespace App\Repositories;

use App\Models\BaseSalary;
use App\Models\User;
use App\Repositories\Interfaces\BaseSalaryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BaseSalaryRepository implements BaseSalaryRepositoryInterface
{
    /**
     * Get all base salary records.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return BaseSalary::all();
    }

    /**
     * Get base salary record by ID.
     *
     * @param int $id
     * @return BaseSalary|null
     */
    public function findById(int $id): ?BaseSalary
    {
        return BaseSalary::find($id);
    }

    /**
     * Create a new base salary record.
     *
     * @param array $data
     * @return BaseSalary
     */
    public function create(array $data): BaseSalary
    {
        return BaseSalary::create($data);
    }

    /**
     * Update a base salary record.
     *
     * @param int $id
     * @param array $data
     * @return BaseSalary|null
     */
    public function update(int $id, array $data): ?BaseSalary
    {
        $baseSalary = $this->findById($id);

        if ($baseSalary) {
            $baseSalary->update($data);
            return $baseSalary;
        }

        return null;
    }

    /**
     * Delete a base salary record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $baseSalary = $this->findById($id);

        if ($baseSalary) {
            return $baseSalary->delete();
        }

        return false;
    }

    /**
     * Get base salary record by user ID.
     *
     * @param int $userId
     * @return BaseSalary|null
     */
    public function findByUserId(int $userId): ?BaseSalary
    {
        return BaseSalary::where('user_id', $userId)->first();
    }

    /**
     * Check if user exists.
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool
    {
        return User::where('id', $userId)->exists();
    }
}
