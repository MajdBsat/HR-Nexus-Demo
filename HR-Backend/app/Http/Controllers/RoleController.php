<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * The role service instance.
     *
     * @var RoleService
     */
    protected $roleService;

    /**
     * Create a new controller instance.
     *
     * @param RoleService $roleService
     * @return void
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the roles.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roles = $this->roleService->getAllRoles();
        return response()->json(['data' => $roles]);
    }

    /**
     * Store a newly created role in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->roleService->createRole($request->all());

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json([
            'message' => $result['message'],
            'data' => $result['data']
        ], 201);
    }

    /**
     * Display the specified role.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $role = $this->roleService->getRoleById($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        return response()->json(['data' => $role]);
    }

    /**
     * Update the specified role in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->roleService->updateRole($id, $request->all());

        if (!$result['success']) {
            if ($result['message'] === 'Role not found') {
                return response()->json(['message' => $result['message']], 404);
            }
            return response()->json($result, 422);
        }

        return response()->json([
            'message' => $result['message'],
            'data' => $result['data']
        ]);
    }

    /**
     * Remove the specified role from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->roleService->deleteRole($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], $result['message'] === 'Role not found' ? 404 : 422);
        }

        return response()->json(['message' => $result['message']]);
    }

    /**
     * Get tasks for a specific role.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getTasks(int $id): JsonResponse
    {
        $result = $this->roleService->getTasksByRoleId($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['data' => $result['data']]);
    }
}
