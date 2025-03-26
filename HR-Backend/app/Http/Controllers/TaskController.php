<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * The task service instance.
     *
     * @var TaskService
     */
    /**
     * Display a listing of the tasks.
     *
     * @return JsonResponse
     */
    static public function index(): JsonResponse
    {
        $tasks = TaskService::getAllTasks();
        return response()->json(['data' => $tasks]);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    static public function createTask(Request $request){
        $result = TaskService::createTask($request->all());
        return $result;
    }
    static public function store(Request $request): JsonResponse
    {
        $result = TaskService::createTask($request->all());

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json([
            'message' => $result['message'],
            'data' => $result['data']
        ], 201);
    }

    /**
     * Display the specified task.
     *
     * @param int $id
     * @return JsonResponse
     */
    static public function show(int $id): JsonResponse
    {
        try {
            $task = TaskService::getTaskById((int)$id);

            if (!$task) {
                return response()->json(['message' => 'Task not found'], 404);
            }

            return response()->json(['data' => $task]);
        } catch (\TypeError $e) {
            return response()->json(['message' => 'Invalid task ID format'], 400);
        }
    }

    /**
     * Update the specified task in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    static public function update(Request $request, int $id): JsonResponse
    {
        $result = TaskService::updateTask($id, $request->all());

        if (!$result['success']) {
            if ($result['message'] === 'Task not found') {
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
     * Remove the specified task from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    static public function destroy(int $id): JsonResponse
    {
        $result = TaskService::deleteTask($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['message' => $result['message']]);
    }

    /**
     * Push task to next status.
     *
     * @param string $id
     * @return JsonResponse
     */

    static public function nextStep(int $id){
        return TaskService::updateTaskStatus($id);
    }

    static public function reject(int $id){
        return TaskService::updateTaskReject($id);
    }
    /**
     * Get tasks by status.
     *
     * @param string $status
     * @return JsonResponse
     */
    static public function getByStatus(string $status): JsonResponse
    {
        $tasks = TaskService::getTasksByStatus($status);
        return response()->json(['data' => $tasks]);
    }

    /**
     * Get tasks by priority.
     *
     * @param string $priority
     * @return JsonResponse
     */
    static public function getByPriority(string $priority): JsonResponse
    {
        $tasks = TaskService::getTasksByPriority($priority);
        return response()->json(['data' => $tasks]);
    }

    /**
     * Get tasks by user ID.
     *
     * @param int $userId
     * @return JsonResponse
     */
    static public function getByUserId(int $userId): JsonResponse
    {
        $result = TaskService::getTasksByUserId($userId);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['data' => $result['data']]);
    }

    /**
     * Get upcoming tasks.
     *
     * @param int $days
     * @return JsonResponse
     */
    static public function getUpcomingTasks(int $days = 7): JsonResponse
    {
        $tasks = TaskService::getUpcomingTasks($days);
        return response()->json(['data' => $tasks]);
    }
}
