<?php

namespace App\Repositories\Interfaces;

use App\Models\InsurancePlan;
use Illuminate\Database\Eloquent\Collection;

interface InsurancePlanRepositoryInterface
{
    /**
     * Get all insurance plans.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find an insurance plan by ID.
     *
     * @param int $id
     * @return InsurancePlan|null
     */
    public function findById(int $id): ?InsurancePlan;

    /**
     * Create a new insurance plan.
     *
     * @param array $data
     * @return InsurancePlan
     */
    public function create(array $data): InsurancePlan;

    /**
     * Update an insurance plan.
     *
     * @param int $id
     * @param array $data
     * @return InsurancePlan|null
     */
    public function update(int $id, array $data): ?InsurancePlan;

    /**
     * Delete an insurance plan.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get insurance plans by type.
     *
     * @param string $type
     * @return Collection
     */
    public function getByType(string $type): Collection;

    /**
     * Get insurance plans by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection;

    /**
     * Get insurance plans by provider.
     *
     * @param string $provider
     * @return Collection
     */
    public function getByProvider(string $provider): Collection;

    /**
     * Get insurance plans for a specific user.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection;

    /**
     * Get active insurance plans.
     *
     * @return Collection
     */
    public function getActivePlans(): Collection;

    /**
     * Check if a user exists.
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool;
}
