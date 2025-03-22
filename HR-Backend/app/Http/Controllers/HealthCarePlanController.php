<?php

namespace App\Http\Controllers;

use App\Services\HealthCarePlanService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HealthCarePlanController extends Controller
{
    /**
     * The health care plan service instance.
     *
     * @var HealthCarePlanService
     */
    protected $healthCarePlanService;

    /**
     * Create a new controller instance.
     *
     * @param HealthCarePlanService $healthCarePlanService
     * @return void
     */
    public function __construct(HealthCarePlanService $healthCarePlanService)
    {
        $this->healthCarePlanService = $healthCarePlanService;
    }

    /**
     * Display a listing of the health care plans.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $healthCarePlans = $this->healthCarePlanService->getAllHealthCarePlans();
        return response()->json([
            'success' => true,
            'data' => $healthCarePlans
        ]);
    }

    /**
     * Store a newly created health care plan in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->healthCarePlanService->createHealthCarePlan($request->all());

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json($result, 201);
    }

    /**
     * Display the specified health care plan.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $healthCarePlan = $this->healthCarePlanService->getHealthCarePlanById($id);

        if (!$healthCarePlan) {
            return response()->json([
                'success' => false,
                'message' => 'Health care plan not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $healthCarePlan
        ]);
    }

    /**
     * Update the specified health care plan in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->healthCarePlanService->updateHealthCarePlan($id, $request->all());

        if (!$result['success']) {
            if ($result['message'] === 'Health care plan not found') {
                return response()->json($result, 404);
            }
            return response()->json($result, 422);
        }

        return response()->json($result);
    }

    /**
     * Remove the specified health care plan from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->healthCarePlanService->deleteHealthCarePlan($id);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * Get health care plans by coverage type.
     *
     * @param string $coverageType
     * @return JsonResponse
     */
    public function getByCoverageType(string $coverageType): JsonResponse
    {
        $result = $this->healthCarePlanService->getHealthCarePlansByCoverageType($coverageType);
        return response()->json($result);
    }

    /**
     * Get active health care plans.
     *
     * @return JsonResponse
     */
    public function getActivePlans(): JsonResponse
    {
        $result = $this->healthCarePlanService->getActiveHealthCarePlans();
        return response()->json($result);
    }

    /**
     * Get health care plans by provider.
     *
     * @param string $provider
     * @return JsonResponse
     */
    public function getByProvider(string $provider): JsonResponse
    {
        $result = $this->healthCarePlanService->getHealthCarePlansByProvider($provider);
        return response()->json($result);
    }

    /**
     * Get health care plans by user ID.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->healthCarePlanService->getHealthCarePlansByUserId($userId);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }
}
