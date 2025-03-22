<?php

namespace App\Http\Controllers;

use App\Services\BenefitPlanService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BenefitPlanController extends Controller
{
    /**
     * The benefit plan service instance.
     *
     * @var BenefitPlanService
     */
    protected $benefitPlanService;

    /**
     * Create a new controller instance.
     *
     * @param BenefitPlanService $benefitPlanService
     * @return void
     */
    public function __construct(BenefitPlanService $benefitPlanService)
    {
        $this->benefitPlanService = $benefitPlanService;
    }

    /**
     * Display a listing of all benefit plans
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $benefitPlans = $this->benefitPlanService->getAllBenefitPlans();
        return response()->json(['data' => $benefitPlans], 200);
    }

    /**
     * Store a newly created benefit plan
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->benefitPlanService->createBenefitPlan($request->all());

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message'],
                'errors' => $result['errors'] ?? null
            ], 422);
        }

        return response()->json([
            'message' => $result['message'],
            'data' => $result['data']
        ], 201);
    }

    /**
     * Display the specified benefit plan
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $benefitPlan = $this->benefitPlanService->getBenefitPlanById($id);

        if (!$benefitPlan) {
            return response()->json(['message' => 'Benefit plan not found'], 404);
        }

        return response()->json(['data' => $benefitPlan], 200);
    }

    /**
     * Update the specified benefit plan
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->benefitPlanService->updateBenefitPlan($id, $request->all());

        if (!$result['success']) {
            $statusCode = isset($result['errors']) ? 422 : 404;
            return response()->json([
                'message' => $result['message'],
                'errors' => $result['errors'] ?? null
            ], $statusCode);
        }

        return response()->json([
            'message' => $result['message'],
            'data' => $result['data']
        ], 200);
    }

    /**
     * Remove the specified benefit plan
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->benefitPlanService->deleteBenefitPlan($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['message' => $result['message']], 200);
    }

    /**
     * Get benefit plans by user ID
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->benefitPlanService->getBenefitPlansByUserId($userId);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['data' => $result['data']], 200);
    }

    /**
     * Get active benefit plans
     *
     * @return JsonResponse
     */
    public function getActivePlans(): JsonResponse
    {
        $result = $this->benefitPlanService->getActiveBenefitPlans();
        return response()->json(['data' => $result['data']], 200);
    }
}
