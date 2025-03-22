<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        return response()->json(['data' => $tasks]);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|string|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|integer',
            'actual_hours' => 'nullable|integer',
        ]);

        $task = Task::create($validated);
        return response()->json(['message' => 'Task created successfully', 'data' => $task], 201);
    }

    /**
     * Display the specified task.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['data' => $task]);
    }

    /**
     * Update the specified task in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|string|in:pending,in_progress,completed,cancelled',
            'priority' => 'sometimes|required|string|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|integer',
            'actual_hours' => 'nullable|integer',
        ]);

        $task->update($validated);
        return response()->json(['message' => 'Task updated successfully', 'data' => $task]);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }

    /**
     * Get tasks by status.
     *
     * @param string $status
     * @return JsonResponse
     */
    public function getByStatus(string $status): JsonResponse
    {
        $tasks = Task::byStatus($status)->get();
        return response()->json(['data' => $tasks]);
    }

    /**
     * Get tasks by priority.
     *
     * @param string $priority
     * @return JsonResponse
     */
    public function getByPriority(string $priority): JsonResponse
    {
        $tasks = Task::byPriority($priority)->get();
        return response()->json(['data' => $tasks]);
    }

    /**
     * Get tasks by assigned user.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $tasks = Task::byAssignedUser($userId)->get();
        return response()->json(['data' => $tasks]);
    }

    /**
     * Get upcoming tasks for the next specified days.
     *
     * @param int $days
     * @return JsonResponse
     */
    public function getUpcomingTasks(int $days = 7): JsonResponse
    {
        $tasks = Task::upcoming($days)->get();
        return response()->json(['data' => $tasks]);
    }
}
