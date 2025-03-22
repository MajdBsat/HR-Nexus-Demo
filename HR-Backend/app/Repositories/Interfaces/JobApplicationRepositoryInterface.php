<?php

namespace App\Repositories\Interfaces;

use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Collection;

interface JobApplicationRepositoryInterface
{
    /**
     * Get all job applications.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find a job application by ID.
     *
     * @param int $id
     * @return JobApplication|null
     */
    public function findById(int $id): ?JobApplication;

    /**
     * Create a new job application.
     *
     * @param array $data
     * @return JobApplication
     */
    public function create(array $data): JobApplication;

    /**
     * Update a job application.
     *
     * @param int $id
     * @param array $data
     * @return JobApplication|null
     */
    public function update(int $id, array $data): ?JobApplication;

    /**
     * Delete a job application.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get job applications by job ID.
     *
     * @param int $jobId
     * @return Collection
     */
    public function getByJobId(int $jobId): Collection;

    /**
     * Get job applications by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection;

    /**
     * Get job applications by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection;

    /**
     * Get job applications by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getByDateRange(string $startDate, string $endDate): Collection;

    /**
     * Get recent job applications.
     *
     * @param int $days
     * @return Collection
     */
    public function getRecent(int $days = 30): Collection;

    /**
     * Check if a job exists.
     *
     * @param int $jobId
     * @return bool
     */
    public function jobExists(int $jobId): bool;

    /**
     * Check if a user exists.
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool;
}
