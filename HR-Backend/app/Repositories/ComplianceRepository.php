<?php

namespace App\Repositories;

use App\Models\Compliance;
use App\Models\User;
use App\Repositories\Interfaces\ComplianceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ComplianceRepository implements ComplianceRepositoryInterface
{
    /**
     * Get all compliance records
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Compliance::all();
    }

    /**
     * Get compliance record by ID
     *
     * @param int $id
     * @return Compliance|null
     */
    public function findById(int $id): ?Compliance
    {
        return Compliance::find($id);
    }

    /**
     * Create a new compliance record
     *
     * @param array $data
     * @return Compliance
     */
    public function create(array $data): Compliance
    {
        return Compliance::create($data);
    }

    /**
     * Update a compliance record
     *
     * @param int $id
     * @param array $data
     * @return Compliance|null
     */
    public function update(int $id, array $data): ?Compliance
    {
        $compliance = $this->findById($id);

        if ($compliance) {
            $compliance->update($data);
            return $compliance;
        }

        return null;
    }

    /**
     * Delete a compliance record
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $compliance = $this->findById($id);

        if ($compliance) {
            return $compliance->delete();
        }

        return false;
    }

    /**
     * Get compliance records by user ID
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return Compliance::where('user_id', $userId)->get();
    }

    /**
     * Get compliance records by status
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        return Compliance::where('status', $status)->get();
    }

    /**
     * Get compliance records by type
     *
     * @param string $type
     * @return Collection
     */
    public function getByType(string $type): Collection
    {
        return Compliance::where('compliance_type', $type)->get();
    }

    /**
     * Get expiring compliance records
     *
     * @param int $daysToExpire
     * @return Collection
     */
    public function getExpiringRecords(int $daysToExpire): Collection
    {
        $expiryDate = Carbon::now()->addDays($daysToExpire);

        return Compliance::whereNotNull('expiry_date')
            ->where('expiry_date', '<=', $expiryDate)
            ->where('status', '!=', 'expired')
            ->get();
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
