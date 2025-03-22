<?php

namespace App\Repositories\Interfaces;

use App\Models\BenefitPlan;
use Illuminate\Database\Eloquent\Collection;

interface BenefitPlanRepositoryInterface
{
    /**
     * Get all benefit plans
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get benefit plan by ID
     *
     * @param int $id
     * @return BenefitPlan|null
     */
    public function findById(int $id): ?BenefitPlan;

    /**
     * Create a new benefit plan
     *
     * @param array $data
     * @return BenefitPlan
     */
    public function create(array $data): BenefitPlan;

    /**
     * Update a benefit plan
     *
     * @param int $id
     * @param array $data
     * @return BenefitPlan|null
     */
    public function update(int $id, array $data): ?BenefitPlan;

    /**
     * Delete a benefit plan
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get benefit plans by user ID
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection;

    /**
     * Get active benefit plans
     *
     * @return Collection
     */
    public function getActivePlans(): Collection;

    /**
     * Check if user exists
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool;
}
