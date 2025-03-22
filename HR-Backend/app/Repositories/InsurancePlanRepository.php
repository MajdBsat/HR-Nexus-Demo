<?php

namespace App\Repositories;

use App\Models\InsurancePlan;
use App\Models\User;
use App\Repositories\Interfaces\InsurancePlanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class InsurancePlanRepository implements InsurancePlanRepositoryInterface
{
    /**
     * Get all insurance plans.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return InsurancePlan::all();
    }

    /**
     * Find an insurance plan by ID.
     *
     * @param int $id
     * @return InsurancePlan|null
     */
    public function findById(int $id): ?InsurancePlan
    {
        return InsurancePlan::find($id);
    }

    /**
     * Create a new insurance plan.
     *
     * @param array $data
     * @return InsurancePlan
     */
    public function create(array $data): InsurancePlan
    {
        return InsurancePlan::create($data);
    }

    /**
     * Update an insurance plan.
     *
     * @param int $id
     * @param array $data
     * @return InsurancePlan|null
     */
    public function update(int $id, array $data): ?InsurancePlan
    {
        $insurancePlan = $this->findById($id);

        if ($insurancePlan) {
            $insurancePlan->update($data);
            return $insurancePlan;
        }

        return null;
    }

    /**
     * Delete an insurance plan.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $insurancePlan = $this->findById($id);

        if ($insurancePlan) {
            return $insurancePlan->delete();
        }

        return false;
    }

    /**
     * Get insurance plans by type.
     *
     * @param string $type
     * @return Collection
     */
    public function getByType(string $type): Collection
    {
        return InsurancePlan::byType($type)->get();
    }

    /**
     * Get insurance plans by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        return InsurancePlan::byStatus($status)->get();
    }

    /**
     * Get insurance plans by provider.
     *
     * @param string $provider
     * @return Collection
     */
    public function getByProvider(string $provider): Collection
    {
        return InsurancePlan::byProvider($provider)->get();
    }

    /**
     * Get insurance plans for a specific user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return InsurancePlan::byUser($userId)->get();
    }

    /**
     * Get active insurance plans.
     *
     * @return Collection
     */
    public function getActivePlans(): Collection
    {
        return InsurancePlan::active()->get();
    }

    /**
     * Check if a user exists.
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool
    {
        return User::where('id', $userId)->exists();
    }
}
