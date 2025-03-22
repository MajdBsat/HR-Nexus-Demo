<?php

namespace App\Http\Controllers;

use App\Services\ComplianceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ComplianceController extends Controller
{
    /**
     * The compliance service instance.
     *
     * @var ComplianceService
     */
    protected $complianceService;

    /**
     * Create a new controller instance.
     *
     * @param ComplianceService $complianceService
     * @return void
     */
    public function __construct(ComplianceService $complianceService)
    {
        $this->complianceService = $complianceService;
    }

    /**
     * Display a listing of all compliance records
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $complianceRecords = $this->complianceService->getAllCompliance();
        return response()->json(['data' => $complianceRecords], 200);
    }

    /**
     * Store a newly created compliance record
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->complianceService->createCompliance($request->all());

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
     * Display the specified compliance record
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $compliance = $this->complianceService->getComplianceById($id);

        if (!$compliance) {
            return response()->json(['message' => 'Compliance record not found'], 404);
        }

        return response()->json(['data' => $compliance], 200);
    }

    /**
     * Update the specified compliance record
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->complianceService->updateCompliance($id, $request->all());

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
     * Remove the specified compliance record
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->complianceService->deleteCompliance($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['message' => $result['message']], 200);
    }

    /**
     * Get compliance records by user ID
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->complianceService->getComplianceByUserId($userId);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['data' => $result['data']], 200);
    }

    /**
     * Get compliance records by status
     *
     * @param string $status
     * @return JsonResponse
     */
    public function getByStatus(string $status): JsonResponse
    {
        $result = $this->complianceService->getComplianceByStatus($status);

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message'],
                'errors' => $result['errors'] ?? null
            ], 422);
        }

        return response()->json(['data' => $result['data']], 200);
    }

    /**
     * Get compliance records by type
     *
     * @param string $type
     * @return JsonResponse
     */
    public function getByType(string $type): JsonResponse
    {
        $result = $this->complianceService->getComplianceByType($type);
        return response()->json(['data' => $result['data']], 200);
    }

    /**
     * Get expiring compliance records
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getExpiring(Request $request): JsonResponse
    {
        $daysToExpire = $request->input('days', 30);
        $result = $this->complianceService->getExpiringCompliance($daysToExpire);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 422);
        }

        return response()->json(['data' => $result['data']], 200);
    }
}
