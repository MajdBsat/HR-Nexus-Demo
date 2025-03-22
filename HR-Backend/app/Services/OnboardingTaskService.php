<?php

namespace App\Services;

use App\Models\OnboardingTask;
use App\Models\Role;
use App\Repositories\Interfaces\OnboardingTaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class OnboardingTaskService
{
    /**
     * The onboarding task repository instance.
     *
     * @var OnboardingTaskRepositoryInterface
     */
    protected $onboardingTaskRepository;

    /**
     * Create a new service instance.
     *
     * @param OnboardingTaskRepositoryInterface $onboardingTaskRepository
     * @return void
     */
    public function __construct(OnboardingTaskRepositoryInterface $onboardingTaskRepository)
    {
        $this->onboardingTaskRepository = $onboardingTaskRepository;
    }

    /**
     * Get all onboarding tasks.
     *
     * @return Collection
     */
    public function getAllOnboardingTasks(): Collection
    {
        return $this->onboardingTaskRepository->getAll();
    }

    /**
     * Get onboarding task by ID.
     *
     * @param int $id
     * @return OnboardingTask|null
     */
    public function getOnboardingTaskById(int $id): ?OnboardingTask
    {
        return $this->onboardingTaskRepository->findById($id);
    }

    /**
     * Create a new onboarding task.
     *
     * @param array $data
     * @return array
     */
    public function createOnboardingTask(array $data): array
    {
        $validator = Validator::make($data, [
            'employee_id' => 'required|integer|exists:users,id',
            'role_id' => 'required|integer|exists:roles,id',
            'task_id' => 'required|integer|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        if (!$this->onboardingTaskRepository->employeeExists($data['employee_id'])) {
            return [
                'success' => false,
                'message' => 'Employee not found'
            ];
        }

        if (!$this->onboardingTaskRepository->roleExists($data['role_id'])) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        if (!$this->onboardingTaskRepository->taskExists($data['task_id'])) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        $onboardingTask = $this->onboardingTaskRepository->create($data);

        return [
            'success' => true,
            'message' => 'Onboarding task created successfully',
            'data' => $onboardingTask
        ];
    }

    /**
     * Update an onboarding task.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateOnboardingTask(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'employee_id' => 'sometimes|integer|exists:users,id',
            'role_id' => 'sometimes|integer|exists:roles,id',
            'task_id' => 'sometimes|integer|exists:tasks,id',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        if (isset($data['employee_id']) && !$this->onboardingTaskRepository->employeeExists($data['employee_id'])) {
            return [
                'success' => false,
                'message' => 'Employee not found'
            ];
        }

        if (isset($data['role_id']) && !$this->onboardingTaskRepository->roleExists($data['role_id'])) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        if (isset($data['task_id']) && !$this->onboardingTaskRepository->taskExists($data['task_id'])) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        $onboardingTask = $this->onboardingTaskRepository->update($id, $data);

        if (!$onboardingTask) {
            return [
                'success' => false,
                'message' => 'Onboarding task not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Onboarding task updated successfully',
            'data' => $onboardingTask
        ];
    }

    /**
     * Delete an onboarding task.
     *
     * @param int $id
     * @return array
     */
    public function deleteOnboardingTask(int $id): array
    {
        $result = $this->onboardingTaskRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Onboarding task not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Onboarding task deleted successfully'
        ];
    }

    /**
     * Get onboarding tasks by employee ID.
     *
     * @param int $employeeId
     * @return array
     */
    public function getOnboardingTasksByEmployeeId(int $employeeId): array
    {
        if (!$this->onboardingTaskRepository->employeeExists($employeeId)) {
            return [
                'success' => false,
                'message' => 'Employee not found'
            ];
        }

        $onboardingTasks = $this->onboardingTaskRepository->getByEmployeeId($employeeId);

        return [
            'success' => true,
            'data' => $onboardingTasks
        ];
    }

    /**
     * Get onboarding tasks by role ID.
     *
     * @param int $roleId
     * @return array
     */
    public function getOnboardingTasksByRoleId(int $roleId): array
    {
        if (!$this->onboardingTaskRepository->roleExists($roleId)) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        $onboardingTasks = $this->onboardingTaskRepository->getByRoleId($roleId);

        return [
            'success' => true,
            'data' => $onboardingTasks
        ];
    }

    /**
     * Get all roles.
     *
     * @return array
     */
    public function getAllRoles(): array
    {
        $roles = $this->onboardingTaskRepository->getAllRoles();

        return [
            'success' => true,
            'data' => $roles
        ];
    }

    /**
     * Get role by ID.
     *
     * @param int $id
     * @return array
     */
    public function getRoleById(int $id): array
    {
        $role = $this->onboardingTaskRepository->getRoleById($id);

        if (!$role) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        return [
            'success' => true,
            'data' => $role
        ];
    }

    /**
     * Create a new role.
     *
     * @param array $data
     * @return array
     */
    public function createRole(array $data): array
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255|unique:roles,title',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $role = $this->onboardingTaskRepository->createRole($data);

        return [
            'success' => true,
            'message' => 'Role created successfully',
            'data' => $role
        ];
    }

    /**
     * Update a role.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateRole(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'title' => 'sometimes|string|max:255|unique:roles,title,' . $id,
            'description' => 'sometimes|string',
            'requirements' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $role = $this->onboardingTaskRepository->updateRole($id, $data);

        if (!$role) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Role updated successfully',
            'data' => $role
        ];
    }

    /**
     * Delete a role.
     *
     * @param int $id
     * @return array
     */
    public function deleteRole(int $id): array
    {
        // Check if there are any onboarding tasks associated with this role
        $tasks = $this->onboardingTaskRepository->getByRoleId($id);
        if ($tasks->isNotEmpty()) {
            return [
                'success' => false,
                'message' => 'Cannot delete role with associated onboarding tasks'
            ];
        }

        $result = $this->onboardingTaskRepository->deleteRole($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Role deleted successfully'
        ];
    }

    /**
     * Get tasks by role ID.
     *
     * @param int $roleId
     * @return array
     */
    public function getTasksByRoleId(int $roleId): array
    {
        if (!$this->onboardingTaskRepository->roleExists($roleId)) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        $tasks = $this->onboardingTaskRepository->getTasksByRoleId($roleId);

        return [
            'success' => true,
            'data' => $tasks
        ];
    }

    /**
     * Assign a task to a role.
     *
     * @param int $roleId
     * @param int $taskId
     * @return array
     */
    public function assignTaskToRole(int $roleId, int $taskId): array
    {
        if (!$this->onboardingTaskRepository->roleExists($roleId)) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        if (!$this->onboardingTaskRepository->taskExists($taskId)) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        $result = $this->onboardingTaskRepository->assignTaskToRole($roleId, $taskId);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Task is already assigned to this role'
            ];
        }

        return [
            'success' => true,
            'message' => 'Task assigned to role successfully'
        ];
    }

    /**
     * Remove a task from a role.
     *
     * @param int $roleId
     * @param int $taskId
     * @return array
     */
    public function removeTaskFromRole(int $roleId, int $taskId): array
    {
        if (!$this->onboardingTaskRepository->roleExists($roleId)) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        if (!$this->onboardingTaskRepository->taskExists($taskId)) {
            return [
                'success' => false,
                'message' => 'Task not found'
            ];
        }

        $result = $this->onboardingTaskRepository->removeTaskFromRole($roleId, $taskId);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Task is not assigned to this role or has already been assigned to employees'
            ];
        }

        return [
            'success' => true,
            'message' => 'Task removed from role successfully'
        ];
    }

    /**
     * Assign role tasks to an employee.
     *
     * @param int $employeeId
     * @param int $roleId
     * @return array
     */
    public function assignRoleTasksToEmployee(int $employeeId, int $roleId): array
    {
        if (!$this->onboardingTaskRepository->employeeExists($employeeId)) {
            return [
                'success' => false,
                'message' => 'Employee not found'
            ];
        }

        if (!$this->onboardingTaskRepository->roleExists($roleId)) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        // Get all tasks for this role (from templates where employee_id is null)
        $roleTasks = OnboardingTask::where('role_id', $roleId)
            ->whereNull('employee_id')
            ->get();

        if ($roleTasks->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No tasks found for this role'
            ];
        }

        // Create employee-specific onboarding tasks
        $createdTasks = [];
        foreach ($roleTasks as $roleTask) {
            $newTask = $this->onboardingTaskRepository->create([
                'employee_id' => $employeeId,
                'role_id' => $roleId,
                'task_id' => $roleTask->task_id
            ]);
            $createdTasks[] = $newTask;
        }

        return [
            'success' => true,
            'message' => count($createdTasks) . ' onboarding tasks assigned to employee',
            'data' => $createdTasks
        ];
    }
}
