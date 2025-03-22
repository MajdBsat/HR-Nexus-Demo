<?php

namespace App\Http\Controllers;

use App\Services\BaseSalaryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BaseSalaryController extends Controller
{
    /**
     * The base salary service instance.
     *
     * @var BaseSalaryService
     */
    protected $baseSalaryService;

    /**
     * Create a new controller instance.
     *
     * @param BaseSalaryService $baseSalaryService
     * @return void
     */
    public function __construct(BaseSalaryService $baseSalaryService)
    {
        $this->baseSalaryService = $baseSalaryService;
    }

    /**
     * Display a listing of all base salary records
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $baseSalaries = $this->baseSalaryService->getAllBaseSalaries();
        return response()->json(['data' => $baseSalaries], 200);
    }

    /**
     * Store a newly created base salary record
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->baseSalaryService->createBaseSalary($request->all());

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
     * Display the specified base salary record
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $baseSalary = $this->baseSalaryService->getBaseSalaryById($id);

        if (!$baseSalary) {
            return response()->json(['message' => 'Base salary record not found'], 404);
        }

        return response()->json(['data' => $baseSalary], 200);
    }

    /**
     * Update the specified base salary record
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->baseSalaryService->updateBaseSalary($id, $request->all());

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
     * Remove the specified base salary record
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->baseSalaryService->deleteBaseSalary($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['message' => $result['message']], 200);
    }

    /**
     * Get base salary record by user ID
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->baseSalaryService->getBaseSalaryByUserId($userId);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['data' => $result['data']], 200);
    }
}
