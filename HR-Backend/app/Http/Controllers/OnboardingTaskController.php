<?php

namespace App\Http\Controllers;

use App\Models\OnboardingTask;
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
        $task = TaskController::createTask($request);
        if(!$task['success']){
                return response()->json($task, 422);
        }
        $validated = $request->validate([
        ]);
        $att = $validated;
        $att["employee_id"] = $task["data"]["id"];
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
}
