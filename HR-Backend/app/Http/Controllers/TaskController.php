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
    protected $taskService;

    /**
     * Create a new controller instance.
     *
     * @param TaskService $taskService
     * @return void
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the tasks.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getAllTasks();
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
        $result = $this->taskService->createTask($request->all());

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
    public function show(int $id): JsonResponse
    {
        try {
            $task = $this->taskService->getTaskById((int)$id);

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
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->taskService->updateTask($id, $request->all());

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
    public function destroy(int $id): JsonResponse
    {
        $result = $this->taskService->deleteTask($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['message' => $result['message']]);
    }

    /**
     * Get tasks by status.
     *
     * @param string $status
     * @return JsonResponse
     */
    public function getByStatus(string $status): JsonResponse
    {
        $tasks = $this->taskService->getTasksByStatus($status);
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
        $tasks = $this->taskService->getTasksByPriority($priority);
        return response()->json(['data' => $tasks]);
    }

    /**
     * Get tasks by user ID.
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->taskService->getTasksByUserId($userId);

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
    public function getUpcomingTasks(int $days = 7): JsonResponse
    {
        $tasks = $this->taskService->getUpcomingTasks($days);
        return response()->json(['data' => $tasks]);
    }
}
