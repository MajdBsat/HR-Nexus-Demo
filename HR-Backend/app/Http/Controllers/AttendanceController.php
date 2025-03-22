<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AttendanceController extends Controller
{
    /**
     * The attendance service instance.
     *
     * @var AttendanceService
     */
    protected $attendanceService;

    /**
     * Create a new controller instance.
     *
     * @param AttendanceService $attendanceService
     * @return void
     */
    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Display a listing of all attendance records
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $attendances = $this->attendanceService->getAllAttendances();
        return response()->json(['data' => $attendances], 200);
    }

    /**
     * Store a newly created attendance record
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->attendanceService->createAttendance($request->all());

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
     * Display the specified attendance record
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $attendance = $this->attendanceService->getAttendanceById($id);

        if (!$attendance) {
            return response()->json(['message' => 'Attendance record not found'], 404);
        }

        return response()->json(['data' => $attendance], 200);
    }

    /**
     * Update the specified attendance record
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->attendanceService->updateAttendance($id, $request->all());

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
     * Remove the specified attendance record
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->attendanceService->deleteAttendance($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['message' => $result['message']], 200);
    }

    /**
     * Get attendance records by user ID
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->attendanceService->getAttendanceByUserId($userId);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['data' => $result['data']], 200);
    }

    /**
     * Get attendance records by date range
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByDateRange(Request $request): JsonResponse
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $userId = $request->input('user_id');

        $result = $this->attendanceService->getAttendanceByDateRange($startDate, $endDate, $userId);

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message'],
                'errors' => $result['errors'] ?? null
            ], 422);
        }

        return response()->json(['data' => $result['data']], 200);
    }
}
