<?php

namespace App\Http\Controllers;

use App\Models\OnboardingTask;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OnboardingTaskController extends Controller
{
    /**
     * Display a listing of the onboarding tasks.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $onboardingTasks = OnboardingTask::with(['employee', 'task'])->get();
        return response()->json(['data' => $onboardingTasks]);
    }

    /**
     * Store a newly created onboarding task in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
        ]);

        $onboardingTask = OnboardingTask::create($validated);
        return response()->json(['message' => 'Onboarding task created successfully', 'data' => $onboardingTask], 201);
    }

    /**
     * Display the specified onboarding task.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $onboardingTask = OnboardingTask::with(['employee', 'task'])->find($id);

        if (!$onboardingTask) {
            return response()->json(['message' => 'Onboarding task not found'], 404);
        }

        return response()->json(['data' => $onboardingTask]);
    }

    /**
     * Update the specified onboarding task in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $onboardingTask = OnboardingTask::find($id);

        if (!$onboardingTask) {
            return response()->json(['message' => 'Onboarding task not found'], 404);
        }

        $validated = $request->validate([
            'employee_id' => 'sometimes|required|exists:users,id',
            'task_id' => 'sometimes|required|exists:tasks,id',
        ]);

        $onboardingTask->update($validated);
        return response()->json(['message' => 'Onboarding task updated successfully', 'data' => $onboardingTask]);
    }

    /**
     * Remove the specified onboarding task from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $onboardingTask = OnboardingTask::find($id);

        if (!$onboardingTask) {
            return response()->json(['message' => 'Onboarding task not found'], 404);
        }

        $onboardingTask->delete();
        return response()->json(['message' => 'Onboarding task deleted successfully']);
    }

    /**
     * Get onboarding tasks by employee ID.
     *
     * @param int $employeeId
     * @return JsonResponse
     */
    public function getByEmployeeId(int $employeeId): JsonResponse
    {
        $onboardingTasks = OnboardingTask::with(['task'])
            ->where('employee_id', $employeeId)
            ->get();

        return response()->json(['data' => $onboardingTasks]);
    }

    /**
     * Get onboarding tasks by role ID.
     *
     * @param int $roleId
     * @return JsonResponse
     */
    // public function getByRoleId(int $roleId): JsonResponse
    // {
    //     $onboardingTasks = OnboardingTask::with(['employee', 'task'])
    //         ->where('role_id', $roleId)
    //         ->get();

    //     return response()->json(['data' => $onboardingTasks]);
    // }

    /**
     * Display a listing of the roles.
     *
     * @return JsonResponse
     */
    // public function roles(): JsonResponse
    // {
    //     $roles = Role::all();
    //     return response()->json(['data' => $roles]);
    // }

    /**
     * Display the specified role.
     *
     * @param int $id
     * @return JsonResponse
     */
    // public function roleShow(int $id): JsonResponse
    // {
    //     $role = Role::find($id);

    //     if (!$role) {
    //         return response()->json(['message' => 'Role not found'], 404);
    //     }

    //     return response()->json(['data' => $role]);
    // }

    /**
     * Store a newly created role in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function roleStore(Request $request): JsonResponse
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'requirements' => 'nullable|string',
    //     ]);

    //     $role = Role::create($validated);
    //     return response()->json(['message' => 'Role created successfully', 'data' => $role], 201);
    // }

    /**
     * Update the specified role in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    // public function roleUpdate(Request $request, int $id): JsonResponse
    // {
    //     $role = Role::find($id);

    //     if (!$role) {
    //         return response()->json(['message' => 'Role not found'], 404);
    //     }

    //     $validated = $request->validate([
    //         'title' => 'sometimes|required|string|max:255',
    //         'description' => 'sometimes|required|string',
    //         'requirements' => 'nullable|string',
    //     ]);

    //     $role->update($validated);
    //     return response()->json(['message' => 'Role updated successfully', 'data' => $role]);
    // }

    /**
     * Remove the specified role from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    // public function roleDestroy(int $id): JsonResponse
    // {
    //     $role = Role::find($id);

    //     if (!$role) {
    //         return response()->json(['message' => 'Role not found'], 404);
    //     }

    //     // Check if role has associated onboarding tasks
    //     if ($role->onboardingTasks()->count() > 0) {
    //         return response()->json(['message' => 'Cannot delete role with associated onboarding tasks'], 422);
    //     }

    //     $role->delete();
    //     return response()->json(['message' => 'Role deleted successfully']);
    // }

    /**
     * Get tasks for a specific role.
     *
     * @param int $roleId
     * @return JsonResponse
     */
    // public function getTasksByRoleId(int $roleId): JsonResponse
    // {
    //     $role = Role::find($roleId);

    //     if (!$role) {
    //         return response()->json(['message' => 'Role not found'], 404);
    //     }

    //     // Get all tasks associated with this role through onboarding tasks
    //     $taskIds = OnboardingTask::where('role_id', $roleId)
    //         ->whereNull('employee_id') // Get only template tasks, not employee-specific ones
    //         ->pluck('task_id')
    //         ->unique();

    //     $tasks = Task::whereIn('id', $taskIds)->get();

    //     return response()->json(['data' => $tasks]);
    // }

    /**
     * Assign a task to a role.
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function assignTaskToRole(Request $request): JsonResponse
    // {
    //     $validated = $request->validate([
    //         'role_id' => 'required|exists:roles,id',
    //         'task_id' => 'required|exists:tasks,id',
    //     ]);

    //     // Check if this assignment already exists
    //     $exists = OnboardingTask::where('role_id', $validated['role_id'])
    //         ->where('task_id', $validated['task_id'])
    //         ->whereNull('employee_id')
    //         ->exists();

    //     if ($exists) {
    //         return response()->json(['message' => 'Task is already assigned to this role'], 422);
    //     }

    //     // Create a template onboarding task (without employee_id)
    //     OnboardingTask::create([
    //         'role_id' => $validated['role_id'],
    //         'task_id' => $validated['task_id'],
    //         'employee_id' => null,
    //     ]);

    //     return response()->json(['message' => 'Task assigned to role successfully']);
    // }

    /**
     * Remove a task from a role.
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function removeTaskFromRole(Request $request): JsonResponse
    // {
    //     $validated = $request->validate([
    //         'role_id' => 'required|exists:roles,id',
    //         'task_id' => 'required|exists:tasks,id',
    //     ]);

    //     // Only delete template tasks (where employee_id is null)
    //     $deleted = OnboardingTask::where('role_id', $validated['role_id'])
    //         ->where('task_id', $validated['task_id'])
    //         ->whereNull('employee_id')
    //         ->delete();

    //     if ($deleted === 0) {
    //         return response()->json(['message' => 'Task is not assigned to this role'], 404);
    //     }

    //     return response()->json(['message' => 'Task removed from role successfully']);
    // }

    /**
     * Assign role tasks to an employee.
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function assignRoleTasksToEmployee(Request $request): JsonResponse
    // {
    //     $validated = $request->validate([
    //         'employee_id' => 'required|exists:users,id',
    //         'role_id' => 'required|exists:roles,id',
    //     ]);

    //     // Get all tasks associated with the role (templates)
    //     $roleTasks = OnboardingTask::where('role_id', $validated['role_id'])
    //         ->whereNull('employee_id')
    //         ->get();

    //     if ($roleTasks->isEmpty()) {
    //         return response()->json(['message' => 'No tasks are associated with this role'], 404);
    //     }

    //     $createdTasks = [];

    //     // Create employee-specific onboarding tasks
    //     foreach ($roleTasks as $roleTask) {
    //         $onboardingTask = OnboardingTask::create([
    //             'employee_id' => $validated['employee_id'],
    //             'role_id' => $validated['role_id'],
    //             'task_id' => $roleTask->task_id,
    //         ]);

    //         $createdTasks[] = $onboardingTask;
    //     }

    //     return response()->json([
    //         'message' => 'Role tasks assigned to employee successfully',
    //         'data' => $createdTasks
    //     ]);
    // }
}
