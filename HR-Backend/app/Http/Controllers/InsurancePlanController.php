<?php

namespace App\Http\Controllers;

use App\Services\InsurancePlanService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InsurancePlanController extends Controller
{
    /**
     * The insurance plan service instance.
     *
     * @var InsurancePlanService
     */
    protected $insurancePlanService;

    /**
     * Create a new controller instance.
     *
     * @param InsurancePlanService $insurancePlanService
     * @return void
     */
    public function __construct(InsurancePlanService $insurancePlanService)
    {
        $this->insurancePlanService = $insurancePlanService;
    }

    /**
     * Display a listing of the insurance plans.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $insurancePlans = $this->insurancePlanService->getAllInsurancePlans();
        return response()->json([
            'success' => true,
            'data' => $insurancePlans
        ]);
    }

    /**
     * Store a newly created insurance plan in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->insurancePlanService->createInsurancePlan($request->all());

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json($result, 201);
    }

    /**
     * Display the specified insurance plan.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $insurancePlan = $this->insurancePlanService->getInsurancePlanById($id);

        if (!$insurancePlan) {
            return response()->json([
                'success' => false,
                'message' => 'Insurance plan not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $insurancePlan
        ]);
    }

    /**
     * Update the specified insurance plan in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->insurancePlanService->updateInsurancePlan($id, $request->all());

        if (!$result['success']) {
            if ($result['message'] === 'Insurance plan not found') {
                return response()->json($result, 404);
            }
            return response()->json($result, 422);
        }

        return response()->json($result);
    }

    /**
     * Remove the specified insurance plan from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->insurancePlanService->deleteInsurancePlan($id);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * Get insurance plans by type.
     *
     * @param string $type
     * @return JsonResponse
     */
    public function getByType(string $type): JsonResponse
    {
        $result = $this->insurancePlanService->getInsurancePlansByType($type);
        return response()->json($result);
    }

    /**
     * Get insurance plans by status.
     *
     * @param string $status
     * @return JsonResponse
     */
    public function getByStatus(string $status): JsonResponse
    {
        $result = $this->insurancePlanService->getInsurancePlansByStatus($status);
        return response()->json($result);
    }

    /**
     * Get insurance plans by provider.
     *
     * @param string $provider
     * @return JsonResponse
     */
    public function getByProvider(string $provider): JsonResponse
    {
        $result = $this->insurancePlanService->getInsurancePlansByProvider($provider);
        return response()->json($result);
    }

    /**
     * Get active insurance plans.
     *
     * @return JsonResponse
     */
    public function getActivePlans(): JsonResponse
    {
        $result = $this->insurancePlanService->getActiveInsurancePlans();
        return response()->json($result);
    }

    /**
     * Get insurance plans by user ID.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->insurancePlanService->getInsurancePlansByUserId($userId);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }
}
