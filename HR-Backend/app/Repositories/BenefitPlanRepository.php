<?php

namespace App\Repositories;

use App\Models\BenefitPlan;
use App\Models\User;
use App\Repositories\Interfaces\BenefitPlanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BenefitPlanRepository implements BenefitPlanRepositoryInterface
{
    /**
     * Get all benefit plans
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return BenefitPlan::all();
    }

    /**
     * Get benefit plan by ID
     *
     * @param int $id
     * @return BenefitPlan|null
     */
    public function findById(int $id): ?BenefitPlan
    {
        return BenefitPlan::find($id);
    }

    /**
     * Create a new benefit plan
     *
     * @param array $data
     * @return BenefitPlan
     */
    public function create(array $data): BenefitPlan
    {
        return BenefitPlan::create($data);
    }

    /**
     * Update a benefit plan
     *
     * @param int $id
     * @param array $data
     * @return BenefitPlan|null
     */
    public function update(int $id, array $data): ?BenefitPlan
    {
        $benefitPlan = $this->findById($id);

        if ($benefitPlan) {
            $benefitPlan->update($data);
            return $benefitPlan;
        }

        return null;
    }

    /**
     * Delete a benefit plan
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $benefitPlan = $this->findById($id);

        if ($benefitPlan) {
            return $benefitPlan->delete();
        }

        return false;
    }

    /**
     * Get benefit plans by user ID
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return BenefitPlan::where('user_id', $userId)->get();
    }

    /**
     * Get active benefit plans
     *
     * @return Collection
     */
    public function getActivePlans(): Collection
    {
        return BenefitPlan::where('status', 'active')->get();
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
