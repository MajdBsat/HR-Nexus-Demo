<?php

namespace App\Repositories\Interfaces;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Collection;

interface JobRepositoryInterface
{
    /**
     * Get all job applications.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find a job by ID.
     *
     * @param int $id
     * @return Job|null
     */
    public function findById(int $id): ?Job;
    /**
     * Create a new job application.
     *
     * @param array $data
     * @return Job
     */
    public function create(array $data): Job;

    /**
     * Update a job application.
     *
     * @param int $id
     * @param array $data
     * @return Job|null
     */
    public function update(int $id, array $data): ?Job;

    /**
     * Delete a job application.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
    public function getJobWithCandidates(int $job_id);
    public function getAllJobsWithCandidates();

}
