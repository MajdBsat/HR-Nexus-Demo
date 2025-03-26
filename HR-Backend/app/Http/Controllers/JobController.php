<?php

namespace App\Http\Controllers;

use App\Services\CandidateService;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    /**
     * The job service instance.
     *
     * @var JobService
     */
    protected $jobService;

    /**
     * Create a new controller instance.
     *
     * @param JobService $jobService
     * @return void
     */
    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * Display a listing of the jobs.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $jobs = $this->jobService->getAllJobs();
        return response()->json([
            'success' => true,
            'data' => $jobs
        ]);
    }

    /**
     * Store a newly created job in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->jobService->createJob($request->all());

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json($result, 201);
    }

    /**
     * Display the specified job.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $job = $this->jobService->getJobById($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $job
        ]);
    }

    /**
     * Update the specified job in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->jobService->updateJob($id, $request->all());

        if (!$result['success']) {
            if ($result['message'] === 'Job not found') {
                return response()->json($result, 404);
            }
            return response()->json($result, 422);
        }

        return response()->json($result);
    }

    /**
     * Remove the specified job from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->jobService->deleteJob($id);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }
    /**
     * Search jobs by criteria.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->search;
        $jobs = $this->jobService->search($search);
        return response()->json([
            'success' => true,
            'data' => $jobs
        ]);
    }

    public function getJobWithCandidates($job_id){
        return $this->jobService->getJobWithCandidates($job_id);
    }

    public function getAllJobsWithCandidates(){
        return $this->jobService->getAllJobsWithCandidates();
    }
}
