<?php

namespace App\Repositories;

use App\Models\HealthCarePlan;
use App\Models\User;
use App\Repositories\Interfaces\HealthCarePlanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class HealthCarePlanRepository implements HealthCarePlanRepositoryInterface
{
    /**
     * Get all health care plans
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return HealthCarePlan::all();
    }

    /**
     * Get health care plan by ID
     *
     * @param int $id
     * @return HealthCarePlan|null
     */
    public function findById(int $id): ?HealthCarePlan
    {
        return HealthCarePlan::find($id);
    }

    /**
     * Create a new health care plan
     *
     * @param array $data
     * @return HealthCarePlan
     */
    public function create(array $data): HealthCarePlan
    {
        return HealthCarePlan::create($data);
    }

    /**
     * Update a health care plan
     *
     * @param int $id
     * @param array $data
     * @return HealthCarePlan|null
     */
    public function update(int $id, array $data): ?HealthCarePlan
    {
        $healthCarePlan = $this->findById($id);

        if ($healthCarePlan) {
            $healthCarePlan->update($data);
            return $healthCarePlan;
        }

        return null;
    }

    /**
     * Delete a health care plan
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $healthCarePlan = $this->findById($id);

        if ($healthCarePlan) {
            return $healthCarePlan->delete();
        }

        return false;
    }

    /**
     * Get health care plans by coverage type
     *
     * @param string $coverageType
     * @return Collection
     */
    public function getByCoverageType(string $coverageType): Collection
    {
        return HealthCarePlan::where('coverage_type', $coverageType)->get();
    }

    /**
     * Get active health care plans
     *
     * @return Collection
     */
    public function getActivePlans(): Collection
    {
        return HealthCarePlan::where('status', 'active')->get();
    }

    /**
     * Get health care plans by provider
     *
     * @param string $provider
     * @return Collection
     */
    public function getByProvider(string $provider): Collection
    {
        return HealthCarePlan::where('provider', $provider)->get();
    }

    /**
     * Get health care plans by user ID
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return HealthCarePlan::where('user_id', $userId)->get();
    }

    /**
     * Check if user exists
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool
    {
        return User::where('id', $userId)->exists();
    }
}
