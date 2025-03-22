<?php

namespace App\Repositories\Interfaces;

use App\Models\Compliance;
use Illuminate\Database\Eloquent\Collection;

interface ComplianceRepositoryInterface
{
    /**
     * Get all compliance records
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get compliance record by ID
     *
     * @param int $id
     * @return Compliance|null
     */
    public function findById(int $id): ?Compliance;

    /**
     * Create a new compliance record
     *
     * @param array $data
     * @return Compliance
     */
    public function create(array $data): Compliance;

    /**
     * Update a compliance record
     *
     * @param int $id
     * @param array $data
     * @return Compliance|null
     */
    public function update(int $id, array $data): ?Compliance;

    /**
     * Delete a compliance record
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get compliance records by user ID
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection;

    /**
     * Get compliance records by status
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection;

    /**
     * Get compliance records by type
     *
     * @param string $type
     * @return Collection
     */
    public function getByType(string $type): Collection;

    /**
     * Get expiring compliance records
     *
     * @param int $daysToExpire
     * @return Collection
     */
    public function getExpiringRecords(int $daysToExpire): Collection;

    /**
     * Check if user exists
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool;
}
