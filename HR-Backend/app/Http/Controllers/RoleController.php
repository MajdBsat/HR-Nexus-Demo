<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roles = Role::all();
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
        ]);

        $role = Role::create($validated);
        return response()->json(['message' => 'Role created successfully', 'data' => $role], 201);
    }

    /**
     * Display the specified role.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $role = Role::find($id);

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
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'requirements' => 'nullable|string',
        ]);

        $role->update($validated);
        return response()->json(['message' => 'Role updated successfully', 'data' => $role]);
    }

    /**
     * Remove the specified role from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        // Check if role has associated onboarding tasks
        if ($role->onboardingTasks()->count() > 0) {
            return response()->json(['message' => 'Cannot delete role with associated onboarding tasks'], 422);
        }

        $role->delete();
        return response()->json(['message' => 'Role deleted successfully']);
    }

    /**
     * Get tasks for a specific role.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getTasks(int $id): JsonResponse
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        // Get all tasks associated with this role through onboarding tasks
        $taskIds = $role->onboardingTasks()->pluck('task_id')->unique();
        $tasks = Task::whereIn('id', $taskIds)->get();

        return response()->json(['data' => $tasks]);
    }
}
