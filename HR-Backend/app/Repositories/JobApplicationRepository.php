<?php

namespace App\Repositories;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use App\Repositories\Interfaces\JobApplicationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class JobApplicationRepository implements JobApplicationRepositoryInterface
{
    /**
     * Get all job applications.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return JobApplication::all();
    }

    /**
     * Find a job application by ID.
     *
     * @param int $id
     * @return JobApplication|null
     */
    public function findById(int $id): ?JobApplication
    {
        return JobApplication::find($id);
    }

    /**
     * Create a new job application.
     *
     * @param array $data
     * @return JobApplication
     */
    public function create(array $data): JobApplication
    {
        return JobApplication::create($data);
    }

    /**
     * Update a job application.
     *
     * @param int $id
     * @param array $data
     * @return JobApplication|null
     */
    public function update(int $id, array $data): ?JobApplication
    {
        $jobApplication = $this->findById($id);

        if ($jobApplication) {
            $jobApplication->update($data);
            return $jobApplication;
        }

        return null;
    }

    /**
     * Delete a job application.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $jobApplication = $this->findById($id);

        if ($jobApplication) {
            return $jobApplication->delete();
        }

        return false;
    }

    /**
     * Get job applications by job ID.
     *
     * @param int $jobId
     * @return Collection
     */
    public function getByJobId(int $jobId): Collection
    {
        return JobApplication::byJob($jobId)->get();
    }

    /**
     * Get job applications by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return JobApplication::byUser($userId)->get();
    }

    /**
     * Get job applications by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        return JobApplication::byStatus($status)->get();
    }

    /**
     * Get job applications by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        return JobApplication::byDateRange($startDate, $endDate)->get();
    }

    /**
     * Get recent job applications.
     *
     * @param int $days
     * @return Collection
     */
    public function getRecent(int $days = 30): Collection
    {
        return JobApplication::recent($days)->get();
    }

    /**
     * Check if a job exists.
     *
     * @param int $jobId
     * @return bool
     */
    public function jobExists(int $jobId): bool
    {
        return Job::where('id', $jobId)->exists();
    }

    /**
     * Check if a user exists.
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool
    {
        return User::where('id', $userId)->exists();
    }
}
