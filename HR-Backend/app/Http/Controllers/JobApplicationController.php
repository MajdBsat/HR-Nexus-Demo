<?php

namespace App\Http\Controllers;

use App\Services\JobApplicationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobApplicationController extends Controller
{
    /**
     * The job application service instance.
     *
     * @var JobApplicationService
     */
    protected $jobApplicationService;

    /**
     * Create a new controller instance.
     *
     * @param JobApplicationService $jobApplicationService
     * @return void
     */
    public function __construct(JobApplicationService $jobApplicationService)
    {
        $this->jobApplicationService = $jobApplicationService;
    }

    /**
     * Display a listing of the job applications.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $jobApplications = $this->jobApplicationService->getAllJobApplications();
        return response()->json([
            'success' => true,
            'data' => $jobApplications
        ]);
    }

    /**
     * Store a newly created job application in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->jobApplicationService->createJobApplication($request->all());

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json($result, 201);
    }

    /**
     * Display the specified job application.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $jobApplication = $this->jobApplicationService->getJobApplicationById($id);

        if (!$jobApplication) {
            return response()->json([
                'success' => false,
                'message' => 'Job application not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jobApplication
        ]);
    }

    /**
     * Update the specified job application in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->jobApplicationService->updateJobApplication($id, $request->all());

        if (!$result['success']) {
            if ($result['message'] === 'Job application not found') {
                return response()->json($result, 404);
            }
            return response()->json($result, 422);
        }

        return response()->json($result);
    }

    /**
     * Remove the specified job application from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->jobApplicationService->deleteJobApplication($id);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * Get job applications by job ID.
     *
     * @param int $jobId
     * @return JsonResponse
     */
    public function getByJobId(int $jobId): JsonResponse
    {
        $result = $this->jobApplicationService->getJobApplicationsByJobId($jobId);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * Get job applications by user ID.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->jobApplicationService->getJobApplicationsByUserId($userId);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * Get job applications by status.
     *
     * @param string $status
     * @return JsonResponse
     */
    public function getByStatus(string $status): JsonResponse
    {
        $result = $this->jobApplicationService->getJobApplicationsByStatus($status);
        return response()->json($result);
    }

    /**
     * Get job applications by date range.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByDateRange(Request $request): JsonResponse
    {
        $validator = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $result = $this->jobApplicationService->getJobApplicationsByDateRange(
            $request->input('start_date'),
            $request->input('end_date')
        );

        return response()->json($result);
    }

    /**
     * Get recent job applications.
     *
     * @param int $days
     * @return JsonResponse
     */
    public function getRecent(int $days = 30): JsonResponse
    {
        $result = $this->jobApplicationService->getRecentJobApplications($days);
        return response()->json($result);
    }
}
