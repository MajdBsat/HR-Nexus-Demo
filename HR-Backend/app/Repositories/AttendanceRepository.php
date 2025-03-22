<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\User;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    /**
     * Get all attendance records.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Attendance::all();
    }

    /**
     * Get attendance record by ID.
     *
     * @param int $id
     * @return Attendance|null
     */
    public function getById(int $id): ?Attendance
    {
        return Attendance::find($id);
    }

    /**
     * Create a new attendance record.
     *
     * @param array $data
     * @return Attendance
     */
    public function create(array $data): Attendance
    {
        return Attendance::create($data);
    }

    /**
     * Update an attendance record.
     *
     * @param int $id
     * @param array $data
     * @return Attendance|null
     */
    public function update(int $id, array $data): ?Attendance
    {
        $attendance = $this->getById($id);

        if ($attendance) {
            $attendance->update($data);
            return $attendance;
        }

        return null;
    }

    /**
     * Delete an attendance record.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $attendance = $this->getById($id);

        if ($attendance) {
            return $attendance->delete();
        }

        return false;
    }

    /**
     * Get attendance records by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return Attendance::where('user_id', $userId)->get();
    }

    /**
     * Get attendance records by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @param int|null $userId
     * @return Collection
     */
    public function getByDateRange(string $startDate, string $endDate, ?int $userId = null): Collection
    {
        $query = Attendance::whereBetween('date', [$startDate, $endDate]);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->get();
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
