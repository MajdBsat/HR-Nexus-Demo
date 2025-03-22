<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class RoleService
{
    /**
     * The role repository instance.
     *
     * @var RoleRepositoryInterface
     */
    protected $roleRepository;

    /**
     * Create a new service instance.
     *
     * @param RoleRepositoryInterface $roleRepository
     * @return void
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get all roles.
     *
     * @return Collection
     */
    public function getAllRoles(): Collection
    {
        return $this->roleRepository->getAll();
    }

    /**
     * Get role by ID.
     *
     * @param int $id
     * @return Role|null
     */
    public function getRoleById(int $id): ?Role
    {
        return $this->roleRepository->findById($id);
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ];
        }

        $role = $this->roleRepository->create($data);

        return [
            'success' => true,
            'message' => 'Role created successfully',
            'data' => $role
        ];
    }

    /**
     * Update an existing role.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateRole(int $id, array $data): array
    {
        $role = $this->roleRepository->findById($id);

        if (!$role) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        $validator = Validator::make($data, [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'requirements' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ];
        }

        $updatedRole = $this->roleRepository->update($id, $data);

        return [
            'success' => true,
            'message' => 'Role updated successfully',
            'data' => $updatedRole
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
        $role = $this->roleRepository->findById($id);

        if (!$role) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        if ($this->roleRepository->hasOnboardingTasks($id)) {
            return [
                'success' => false,
                'message' => 'Cannot delete role with associated onboarding tasks'
            ];
        }

        $this->roleRepository->delete($id);

        return [
            'success' => true,
            'message' => 'Role deleted successfully'
        ];
    }

    /**
     * Get all tasks associated with a role.
     *
     * @param int $roleId
     * @return array
     */
    public function getTasksByRoleId(int $roleId): array
    {
        $role = $this->roleRepository->findById($roleId);

        if (!$role) {
            return [
                'success' => false,
                'message' => 'Role not found'
            ];
        }

        $tasks = $this->roleRepository->getTasks($roleId);

        return [
            'success' => true,
            'data' => $tasks
        ];
    }
}
