<?php

namespace App\Services;

use App\Models\Job;
use App\Repositories\Interfaces\JobRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class JobService
{
    /**
     * The job repository instance.
     *
     * @var JobRepositoryInterface
     */
    protected $jobRepository;

    /**
     * Create a new service instance.
     *
     * @param JobRepositoryInterface $jobRepository
     * @return void
     */
    public function __construct(JobRepositoryInterface $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * Get all jobs.
     *
     * @return Collection
     */
    public function getAllJobs(): Collection
    {
        return $this->jobRepository->getAll();
    }

    /**
     * Get job by ID.
     *
     * @param int $id
     * @return Job|null
     */
    public function getJobById(int $id): ?Job
    {
        return $this->jobRepository->findById($id);
    }

    /**
     * Create a new job.
     *
     * @param array $data
     * @return array
     */
    public function createJob(array $data): array
    {
        // Validate data
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'requirement' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ];
        }

        $job = $this->jobRepository->create($data);

        return [
            'success' => true,
            'message' => 'Job created successfully',
            'data' => $job
        ];
    }

    /**
     * Update an existing Job.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateJob(int $id, array $data): array
    {
        $task = $this->jobRepository->findById($id);

        if (!$task) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        // Validate data
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'requirement' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ];
        }

        $updatedJob = $this->jobRepository->update($id, $data);

        return [
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $updatedJob
        ];
    }

    /**
     * Delete a job.
     *
     * @param int $id
     * @return array
     */
    public function deleteJob(int $id): array
    {
        $task = $this->jobRepository->findById($id);

        if (!$task) {
            return [
                'success' => false,
                'message' => 'job not found'
            ];
        }

        $this->jobRepository->delete($id);

        return [
            'success' => true,
            'message' => 'Job deleted successfully'
        ];
    }
    /**
     * Search job by requirements or description or title
     *
     * @param string $searchTerm
     * @return Collection
     */
    public function search(string $searchTerm): Collection
    {
        return Job::where('requirements', 'like', "%{$searchTerm}%")
            ->orWhere('description', 'like', "%{$searchTerm}%")
            ->orWhere('title', 'like', "%{$searchTerm}%")
            ->get();
    }
}
