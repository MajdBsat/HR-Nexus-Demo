<?php

namespace App\Http\Controllers;

use App\Services\DepartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * The department service instance.
     *
     * @var DepartmentService
     */
    protected $departmentService;

    /**
     * Create a new controller instance.
     *
     * @param DepartmentService $departmentService
     * @return void
     */
    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    /**
     * Display a listing of departments.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $departments = $this->departmentService->getAllDepartments();

        return response()->json([
            'success' => true,
            'data' => $departments
        ]);
    }

    /**
     * Store a newly created department.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'manager_id' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $department = $this->departmentService->createDepartment($request->all());

        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Manager not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $department,
            'message' => 'Department created successfully.'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified department.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $department = $this->departmentService->getDepartmentById((int)$id);

            if (!$department) {
                return response()->json([
                    'success' => false,
                    'message' => 'Department not found.'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'data' => $department
            ]);
        } catch (\TypeError $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid department ID format.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified department.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:100',
            'manager_id' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $department = $this->departmentService->updateDepartment($id, $request->all());

        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found or manager not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $department,
            'message' => 'Department updated successfully.'
        ]);
    }

    /**
     * Remove the specified department.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->departmentService->deleteDepartment($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully.'
        ]);
    }
}
