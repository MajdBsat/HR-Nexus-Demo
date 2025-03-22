<?php

namespace App\Repositories\Interfaces;

use App\Models\HealthCarePlan;
use Illuminate\Database\Eloquent\Collection;

interface HealthCarePlanRepositoryInterface
{
    /**
     * Get all health care plans
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get health care plan by ID
     *
     * @param int $id
     * @return HealthCarePlan|null
     */
    public function findById(int $id): ?HealthCarePlan;

    /**
     * Create a new health care plan
     *
     * @param array $data
     * @return HealthCarePlan
     */
    public function create(array $data): HealthCarePlan;

    /**
     * Update a health care plan
     *
     * @param int $id
     * @param array $data
     * @return HealthCarePlan|null
     */
    public function update(int $id, array $data): ?HealthCarePlan;

    /**
     * Delete a health care plan
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get health care plans by coverage type
     *
     * @param string $coverageType
     * @return Collection
     */
    public function getByCoverageType(string $coverageType): Collection;

    /**
     * Get active health care plans
     *
     * @return Collection
     */
    public function getActivePlans(): Collection;

    /**
     * Get health care plans by provider
     *
     * @param string $provider
     * @return Collection
     */
    public function getByProvider(string $provider): Collection;

    /**
     * Get health care plans by user ID
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection;

    /**
     * Check if user exists
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool;
}
