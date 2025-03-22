<?php

namespace App\Repositories\Interfaces;

interface AttendanceRepositoryInterface
{
    /**
     * Get all attendance records
     *
     * @return mixed
     */
    public function getAll();

    /**
     * Get attendance record by ID
     *
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * Create a new attendance record
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update an attendance record
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * Delete an attendance record
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id);

    /**
     * Get attendance records by user ID
     *
     * @param int $userId
     * @return mixed
     */
    public function getByUserId(int $userId);

    /**
     * Get attendance records by date range
     *
     * @param string $startDate
     * @param string $endDate
     * @param int|null $userId
     * @return mixed
     */
    public function getByDateRange(string $startDate, string $endDate, ?int $userId = null);
}
