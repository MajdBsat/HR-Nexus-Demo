<?php

namespace App\Services;

use App\Models\HrProject;
use App\Repositories\Interfaces\HrProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class HrProjectService
{
    /**
     * The HR project repository instance.
     *
     * @var HrProjectRepositoryInterface
     */
    protected $hrProjectRepository;

    /**
     * Create a new service instance.
     *
     * @param HrProjectRepositoryInterface $hrProjectRepository
     * @return void
     */
    public function __construct(HrProjectRepositoryInterface $hrProjectRepository)
    {
        $this->hrProjectRepository = $hrProjectRepository;
    }

    /**
     * Get all HR projects.
     *
     * @return Collection
     */
    public function getAllHrProjects(): Collection
    {
        return $this->hrProjectRepository->getAll();
    }

    /**
     * Get HR project by ID.
     *
     * @param int $id
     * @return HrProject|null
     */
    public function getHrProjectById(int $id): ?HrProject
    {
        return $this->hrProjectRepository->findById($id);
    }

    /**
     * Create a new HR project.
     *
     * @param array $data
     * @return array
     */
    public function createHrProject(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|in:pending,in-progress,completed,cancelled',
            'priority' => 'required|string|in:low,medium,high',
            'due_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $hrProject = $this->hrProjectRepository->create($data);

        return [
            'success' => true,
            'message' => 'HR project created successfully',
            'data' => $hrProject
        ];
    }

    /**
     * Update an HR project.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateHrProject(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'status' => 'required|string|in:pending,in-progress,completed,cancelled',
            'priority' => 'required|string|in:low,medium,high',
            'due_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $hrProject = $this->hrProjectRepository->update($id, $data);

        if (!$hrProject) {
            return [
                'success' => false,
                'message' => 'HR project not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'HR project updated successfully',
            'data' => $hrProject
        ];
    }

    /**
     * Delete an HR project.
     *
     * @param int $id
     * @return array
     */
    public function deleteHrProject(int $id): array
    {
        $result = $this->hrProjectRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'HR project not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'HR project deleted successfully'
        ];
    }
    /**
     * Get HR projects by status.
     *
     * @param string $status
     * @return array
     */
    public function getHrProjectsByStatus(string $status): array
    {
        $hrProjects = $this->hrProjectRepository->getByStatus($status);

        return [
            'success' => true,
            'data' => $hrProjects
        ];
    }

    /**
     * Get HR projects by priority.
     *
     * @param string $priority
     * @return array
     */
    public function getHrProjectsByPriority(string $priority): array
    {
        $hrProjects = $this->hrProjectRepository->getByPriority($priority);

        return [
            'success' => true,
            'data' => $hrProjects
        ];
    }

    /**
     * Get HR projects with upcoming due dates.
     *
     * @param int $days
     * @return array
     */
    public function getUpcomingHrProjects(int $days = 7): array
    {
        $hrProjects = $this->hrProjectRepository->getUpcomingDueDates($days);

        return [
            'success' => true,
            'data' => $hrProjects
        ];
    }
}
