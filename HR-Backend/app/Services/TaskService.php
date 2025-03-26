<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskService
{
    /**
     * The task repository instance.
     *
     * @var TaskRepositoryInterface
     */

    /**
     * Get all tasks.
     *
     * @return Collection
     */
    static public function getAllTasks(): Collection
    {
        return TaskRepository::getAll();
    }

    /**
     * Get task by ID.
     *
     * @param int $id
     * @return Task|null
     */
    static public function getTaskById(int $id): ?Task
    {
        return TaskRepository::findById($id);
    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return array
     */
    static public function createTask(array $data): array
    {
        // Validate data
        if($data['assigned_to']==-1){
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
                'status' => 'required|string|in:pending,in_progress,completed',
                'priority' => 'required|string|in:low,medium,high',
                'due_date' => 'required|date',
            ]);
        }else{
            $validator = Validator::make($data, [
                'title' => 'required|string|max:255',
                'status' => 'required|string|in:pending,in_progress,completed',
                'priority' => 'required|string|in:low,medium,high',
                'due_date' => 'required|date',
                'assigned_to' => 'integer|exists:users,id',
            ]);
        }


        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ];
        }
        $user = (new UserService(new UserRepository))->getUserById($data['assigned_to']);


        if (isset($user["user_type"])  && $user["user_type"]!=1 &&  $user["user_type"]!=2) {
            return [
                'success' => false,
                '' => 'Assigned user is neither an employee nor a HR'
            ];
        }

        $task = TaskRepository::create($data);

        return [
            'success' => true,
            'message' => 'Task created successfully',
            'data' => $task
        ];
    }

    /**
     * Update an existing task.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    static public function updateTask(int $id, array $data): array
    {
        $task = TaskRepository::findById($id);

        if (!$task) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        // Validate data
        $validator = Validator::make($data, [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|string|in:pending,in_progress,completed,cancelled',
            'priority' => 'sometimes|required|string|in:low,medium,high',
            'due_date' => 'sometimes|required|date',
            'assigned_to' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ];
        }
        $user = (new UserService(new UserRepository))->getUserById($data['assigned_to']);
        // Check if assigned user exists
        if ($user["user_type"]!=1 &&  $user["user_type"]!=2) {
            return [
                'success' => false,
                'message' => 'Assigned user is neither an employee nor a HR'
            ];
        }

        $updatedTask = TaskRepository::update($id, $data);
        return [
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $updatedTask
        ];
    }

    /**
     * Delete a task.
     *
     * @param int $id
     * @return array
     */
    static public function deleteTask(int $id): array
    {
        $task = TaskRepository::findById($id);

        if (!$task) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        TaskRepository::delete($id);

        return [
            'success' => true,
            'message' => 'Task deleted successfully'
        ];
    }

    /**
     * Get tasks by status.
     *
     * @param string $status
     * @return Collection
     */
    static public function getTasksByStatus(string $status): Collection
    {
        return TaskRepository::getByStatus($status);
    }


    static public function updateTaskStatus(int $id){
        $task = TaskRepository::findById($id);
        if (!$task) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }
        if($task['status'] == 'pending'){
            $updated_task = TaskRepository::update($id,["status"=>"in-progress"]);
        }

        if($task['status'] == 'in-progress'){
            $updated_task = TaskRepository::update($id,["status"=>"completed"]);
        }
        //After checking the user type
        $user = Auth::user();
        if($user["user_type"] == 2 && $task['status'] == 'completed'){
            TaskRepository::delete($id);
        }
        return [
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $updated_task? $updated_task: $task
        ];
    }

    static function updateTaskReject(int $id){
        $task = TaskRepository::findById($id);
        if (!$task) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }
        $updated_task = TaskRepository::update($id,["status"=>"pending"]);
        return [
            'success' => true,
            'message' => 'Task updated successfully',
            'data' => $updated_task? $updated_task: $task
        ];
    }

    /**
     * Get tasks by priority.
     *
     * @param string $priority
     * @return Collection
     */
    static public function getTasksByPriority(string $priority): Collection
    {
        return TaskRepository::getByPriority($priority);
    }

    /**
     * Get tasks by user ID.
     *
     * @param int $userId
     * @return array
     */
    static public function getTasksByUserId(int $userId): array
    {
        if (!TaskRepository::userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $tasks = TaskRepository::getByUserId($userId);

        return [
            'success' => true,
            'data' => $tasks
        ];
    }

    /**
     * Get upcoming tasks.
     *
     * @param int $days
     * @return Collection
     */
    static public function getUpcomingTasks(int $days = 7): Collection
    {
        return TaskRepository::getUpcomingTasks($days);
    }
}
