<?php

namespace App\Http\Controllers;

use App\Services\HrProjectService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HrProjectController extends Controller
{
    /**
     * The HR project service instance.
     *
     * @var HrProjectService
     */
    protected $hrProjectService;

    /**
     * Create a new controller instance.
     *
     * @param HrProjectService $hrProjectService
     * @return void
     */
    public function __construct(HrProjectService $hrProjectService)
    {
        $this->hrProjectService = $hrProjectService;
    }

    /**
     * Display a listing of the HR projects.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $hrProjects = $this->hrProjectService->getAllHrProjects();
        return response()->json([
            'success' => true,
            'data' => $hrProjects
        ]);
    }

    /**
     * Store a newly created HR project in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->hrProjectService->createHrProject($request->all());

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json($result, 201);
    }

    /**
     * Display the specified HR project.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $hrProject = $this->hrProjectService->getHrProjectById($id);

        if (!$hrProject) {
            return response()->json([
                'success' => false,
                'message' => 'HR project not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $hrProject
        ]);
    }

    /**
     * Update the specified HR project in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->hrProjectService->updateHrProject($id, $request->all());

        if (!$result['success']) {
            if ($result['message'] === 'HR project not found') {
                return response()->json($result, 404);
            }
            return response()->json($result, 422);
        }

        return response()->json($result);
    }

    /**
     * Remove the specified HR project from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->hrProjectService->deleteHrProject($id);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * Get HR projects by status.
     *
     * @param string $status
     * @return JsonResponse
     */
    public function getByStatus(string $status): JsonResponse
    {
        $result = $this->hrProjectService->getHrProjectsByStatus($status);
        return response()->json($result);
    }

    /**
     * Get HR projects by priority.
     *
     * @param string $priority
     * @return JsonResponse
     */
    public function getByPriority(string $priority): JsonResponse
    {
        $result = $this->hrProjectService->getHrProjectsByPriority($priority);
        return response()->json($result);
    }

    /**
     * Get HR projects with upcoming due dates.
     *
     * @param int $days
     * @return JsonResponse
     */
    public function getUpcomingProjects(int $days = 7): JsonResponse
    {
        $result = $this->hrProjectService->getUpcomingHrProjects($days);
        return response()->json($result);
    }
}
