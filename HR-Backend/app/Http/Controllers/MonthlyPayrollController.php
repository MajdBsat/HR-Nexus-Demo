<?php

namespace App\Http\Controllers;

use App\Services\MonthlyPayrollService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MonthlyPayrollController extends Controller
{
    /**
     * The monthly payroll service instance.
     *
     * @var MonthlyPayrollService
     */
    protected $monthlyPayrollService;

    /**
     * Create a new controller instance.
     *
     * @param MonthlyPayrollService $monthlyPayrollService
     * @return void
     */
    public function __construct(MonthlyPayrollService $monthlyPayrollService)
    {
        $this->monthlyPayrollService = $monthlyPayrollService;
    }

    /**
     * Display a listing of monthly payrolls.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $monthlyPayrolls = $this->monthlyPayrollService->getAllMonthlyPayrolls();
        return response()->json([
            'success' => true,
            'data' => $monthlyPayrolls
        ]);
    }

    /**
     * Store a newly created monthly payroll.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->monthlyPayrollService->createMonthlyPayroll($request->all());

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result, 201);
    }

    /**
     * Display the specified monthly payroll.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $monthlyPayroll = $this->monthlyPayrollService->getMonthlyPayrollById($id);

        if (!$monthlyPayroll) {
            return response()->json([
                'success' => false,
                'message' => 'Monthly payroll not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $monthlyPayroll
        ]);
    }

    /**
     * Update the specified monthly payroll.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->monthlyPayrollService->updateMonthlyPayroll($id, $request->all());

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    /**
     * Remove the specified monthly payroll.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->monthlyPayrollService->deleteMonthlyPayroll($id);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * Get monthly payrolls by month and year.
     *
     * @param int $month
     * @param int $year
     * @return JsonResponse
     */
    public function getByMonthYear(int $month, int $year): JsonResponse
    {
        $result = $this->monthlyPayrollService->getMonthlyPayrollsByMonthYear($month, $year);
        return response()->json($result);
    }

    /**
     * Get monthly payrolls by user ID.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->monthlyPayrollService->getMonthlyPayrollsByUserId($userId);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * Get monthly payrolls by status.
     *
     * @param string $status
     * @return JsonResponse
     */
    public function getByStatus(string $status): JsonResponse
    {
        $result = $this->monthlyPayrollService->getMonthlyPayrollsByStatus($status);
        return response()->json($result);
    }

    /**
     * Get monthly payrolls by department ID.
     *
     * @param int $departmentId
     * @return JsonResponse
     */
    public function getByDepartmentId(int $departmentId): JsonResponse
    {
        $result = $this->monthlyPayrollService->getMonthlyPayrollsByDepartmentId($departmentId);

        if (!$result['success']) {
            return response()->json($result, 404);
        }

        return response()->json($result);
    }

    /**
     * Get monthly payrolls by date range.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByDateRange(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $result = $this->monthlyPayrollService->getMonthlyPayrollsByDateRange(
            $request->input('start_date'),
            $request->input('end_date')
        );

        return response()->json($result);
    }

    /**
     * Get the total payroll amount for a specific month and year.
     *
     * @param int $month
     * @param int $year
     * @return JsonResponse
     */
    public function getTotalPayrollAmount(int $month, int $year): JsonResponse
    {
        $result = $this->monthlyPayrollService->getTotalPayrollAmount($month, $year);
        return response()->json($result);
    }

    /**
     * Approve a monthly payroll.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function approvePayroll(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'approved_by' => 'required|integer|exists:users,id'
        ]);

        $result = $this->monthlyPayrollService->approveMonthlyPayroll(
            $id,
            $request->input('approved_by')
        );

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    /**
     * Mark a monthly payroll as paid.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function markAsPaid(Request $request, int $id): JsonResponse
    {
        $result = $this->monthlyPayrollService->markMonthlyPayrollAsPaid(
            $id,
            $request->all()
        );

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    /**
     * Cancel a monthly payroll.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function cancelPayroll(Request $request, int $id): JsonResponse
    {
        $result = $this->monthlyPayrollService->cancelMonthlyPayroll(
            $id,
            $request->input('notes')
        );

        if (!$result['success']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }
}
