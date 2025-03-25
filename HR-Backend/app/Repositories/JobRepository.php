<?php

namespace App\Repositories;

use App\Models\Job;
use App\Models\User;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class JobRepository implements JobRepositoryInterface
{
    /**
     * Get all jobs.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Job::all();
    }

    /**
     * Find job by ID.
     *
     * @param int $id
     * @return Job|null
     */
    public function findById(int $id): ?Job
    {
        return Job::find($id);
    }

    /**
     * Create a new job.
     *
     * @param array $data
     * @return Job
     */
    public function create(array $data): Job
    {
        return Job::create($data);
    }

    /**
     * Update an existing task.
     *
     * @param int $id
     * @param array $data
     * @return Job|null
     */
    public function update(int $id, array $data): ?Job
    {
        $task = $this->findById($id);

        if (!$task) {
            return null;
        }

        $task->update($data);
        return $task;
    }

    /**
     * Delete a task.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $job = $this->findById($id);

        if (!$job) {
            return false;
        }

        return $job->delete();
    }
}
