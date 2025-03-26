<?php

namespace App\Repositories\Interfaces;

use App\Models\HrProject;
use Illuminate\Database\Eloquent\Collection;

interface HrProjectRepositoryInterface
{
    /**
     * Get all HR projects with relationships.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get a specific HR project by ID.
     *
     * @param int $id
     * @return HrProject|null
     */
    public function findById(int $id): ?HrProject;

    /**
     * Create a new HR project.
     *
     * @param array $data
     * @return HrProject
     */
    public function create(array $data): HrProject;

    /**
     * Update an existing HR project.
     *
     * @param int $id
     * @param array $data
     * @return HrProject|null
     */
    public function update(int $id, array $data): ?HrProject;

    /**
     * Delete an HR project.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get HR projects by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection;

    /**
     * Get HR projects by priority.
     *
     * @param string $priority
     * @return Collection
     */
    public function getByPriority(string $priority): Collection;

    /**
     * Get HR projects with upcoming due dates.
     *
     * @param int $days
     * @return Collection
     */
    public function getUpcomingDueDates(int $days): Collection;
}
