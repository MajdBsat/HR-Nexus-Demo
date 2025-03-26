<?php

namespace App\Http\Controllers;

use App\Models\HrProjectTask;
use App\Services\HrProjectTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class HrProjectTaskController extends Controller
{
    /**
     * The HrProjectTask service instance.
     *
     * @var HrProjectTaskService
     */
    protected $hrProjectTaskService;

    /**
     * Create a new controller instance.
     *
     * @param HrProjectTaskService $hrProjectTaskService
     * @return void
     */
    public function __construct(HrProjectTaskService $hrProjectTaskService)
    {
        $this->hrProjectTaskService = $hrProjectTaskService;
    }

    /**
     * Display a listing of the project tasks.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $projectTasks = $this->hrProjectTaskService->getAllProjectTasks();

        return response()->json([
            'success' => true,
            'data' => $projectTasks
        ]);
    }

    /**
     * Store a newly created project task.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $task = TaskController::createTask($request);
        if(!$task['success']){
            return response()->json([
                'success' => false,
                'errors' => $task['errors']
            ]);
        }
        $request['task_id']=$task['data']['id'];
        $validator = Validator::make($request->all(), [
            'hr_project_id' => 'required|exists:hr_projects,id',
            'task_id' => 'required|exists:tasks,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $projectTask = $this->hrProjectTaskService->createProjectTask($request->all());

        if (!$projectTask) {
            return response()->json([
                'success' => false,
                'message' => 'This task is already assigned to the project.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $projectTask,
            'message' => 'Task assigned to project successfully.'
        ]);
    }

    /**
     * Display the specified project task.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $projectTask = $this->hrProjectTaskService->getProjectTaskById($id);

        if (!$projectTask) {
            return response()->json([
                'success' => false,
                'message' => 'Project task not found.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $projectTask
        ]);
    }

    /**
     * Get all tasks for a specific project.
     *
     * @param int $projectId
     * @return JsonResponse
     */
    public function getProjectTasks(int $projectId): JsonResponse
    {
        if (!$this->hrProjectTaskService->projectExists($projectId)) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $tasks = $this->hrProjectTaskService->getTasksByProjectId($projectId);

        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    /**
     * Get all projects for a specific task.
     *
     * @param int $taskId
     * @return JsonResponse
     */
    public function getTaskProjects(int $taskId): JsonResponse
    {
        if (!$this->hrProjectTaskService->taskExists($taskId)) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $projects = $this->hrProjectTaskService->getProjectsByTaskId($taskId);

        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    /**
     * Remove the specified task from project.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->hrProjectTaskService->deleteProjectTask($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Project task not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Task removed from project successfully.'
        ]);
    }
}
