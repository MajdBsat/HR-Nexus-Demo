<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Repositories\Interfaces\JobApplicationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class JobApplicationService
{
    /**
     * The job application repository instance.
     *
     * @var JobApplicationRepositoryInterface
     */
    protected $jobApplicationRepository;

    /**
     * Create a new service instance.
     *
     * @param JobApplicationRepositoryInterface $jobApplicationRepository
     * @return void
     */
    public function __construct(JobApplicationRepositoryInterface $jobApplicationRepository)
    {
        $this->jobApplicationRepository = $jobApplicationRepository;
    }

    /**
     * Get all job applications.
     *
     * @return Collection
     */
    public function getAllJobApplications(): Collection
    {
        return $this->jobApplicationRepository->getAll();
    }

    /**
     * Get job application by ID.
     *
     * @param int $id
     * @return JobApplication|null
     */
    public function getJobApplicationById(int $id): ?JobApplication
    {
        return $this->jobApplicationRepository->findById($id);
    }

    /**
     * Create a new job application.
     *
     * @param array $data
     * @return array
     */
    public function createJobApplication(array $data): array
    {
        $validator = Validator::make($data, [
            'job_id' => 'required|integer|exists:jobs,id',
            'user_id' => 'required|integer|exists:users,id',
            'application_date' => 'required|date',
            'status' => 'required|string|in:Applied,Shortlisted,Interviewing,Offered,Hired,Rejected',
            'cover_letter' => 'nullable|string',
            'resume_path' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'education' => 'nullable|json',
            'experience' => 'nullable|json',
            'skills' => 'nullable|json',
            'references' => 'nullable|json',
            'interview_notes' => 'nullable|json',
            'assessments' => 'nullable|json',
            'metadata' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        if (!$this->jobApplicationRepository->jobExists($data['job_id'])) {
            return [
                'success' => false,
                'message' => 'Job not found'
            ];
        }

        if (!$this->jobApplicationRepository->userExists($data['user_id'])) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $jobApplication = $this->jobApplicationRepository->create($data);

        return [
            'success' => true,
            'message' => 'Job application created successfully',
            'data' => $jobApplication
        ];
    }

    /**
     * Update a job application.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateJobApplication(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'job_id' => 'sometimes|integer|exists:jobs,id',
            'user_id' => 'sometimes|integer|exists:users,id',
            'application_date' => 'sometimes|date',
            'status' => 'sometimes|string|in:Applied,Shortlisted,Interviewing,Offered,Hired,Rejected',
            'cover_letter' => 'nullable|string',
            'resume_path' => 'nullable|string|max:255',
            'additional_info' => 'nullable|string',
            'education' => 'nullable|json',
            'experience' => 'nullable|json',
            'skills' => 'nullable|json',
            'references' => 'nullable|json',
            'interview_notes' => 'nullable|json',
            'assessments' => 'nullable|json',
            'metadata' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        if (isset($data['job_id']) && !$this->jobApplicationRepository->jobExists($data['job_id'])) {
            return [
                'success' => false,
                'message' => 'Job not found'
            ];
        }

        if (isset($data['user_id']) && !$this->jobApplicationRepository->userExists($data['user_id'])) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $jobApplication = $this->jobApplicationRepository->update($id, $data);

        if (!$jobApplication) {
            return [
                'success' => false,
                'message' => 'Job application not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Job application updated successfully',
            'data' => $jobApplication
        ];
    }

    /**
     * Delete a job application.
     *
     * @param int $id
     * @return array
     */
    public function deleteJobApplication(int $id): array
    {
        $result = $this->jobApplicationRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Job application not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Job application deleted successfully'
        ];
    }

    /**
     * Get job applications by job ID.
     *
     * @param int $jobId
     * @return array
     */
    public function getJobApplicationsByJobId(int $jobId): array
    {
        if (!$this->jobApplicationRepository->jobExists($jobId)) {
            return [
                'success' => false,
                'message' => 'Job not found'
            ];
        }

        $jobApplications = $this->jobApplicationRepository->getByJobId($jobId);

        return [
            'success' => true,
            'data' => $jobApplications
        ];
    }

    /**
     * Get job applications by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getJobApplicationsByUserId(int $userId): array
    {
        if (!$this->jobApplicationRepository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $jobApplications = $this->jobApplicationRepository->getByUserId($userId);

        return [
            'success' => true,
            'data' => $jobApplications
        ];
    }

    /**
     * Get job applications by status.
     *
     * @param string $status
     * @return array
     */
    public function getJobApplicationsByStatus(string $status): array
    {
        $jobApplications = $this->jobApplicationRepository->getByStatus($status);

        return [
            'success' => true,
            'data' => $jobApplications
        ];
    }

    /**
     * Get job applications by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getJobApplicationsByDateRange(string $startDate, string $endDate): array
    {
        $jobApplications = $this->jobApplicationRepository->getByDateRange($startDate, $endDate);

        return [
            'success' => true,
            'data' => $jobApplications
        ];
    }

    /**
     * Get recent job applications.
     *
     * @param int $days
     * @return array
     */
    public function getRecentJobApplications(int $days = 30): array
    {
        $jobApplications = $this->jobApplicationRepository->getRecent($days);

        return [
            'success' => true,
            'data' => $jobApplications
        ];
    }
}
