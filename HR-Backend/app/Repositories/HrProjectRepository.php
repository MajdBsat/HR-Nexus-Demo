<?php

namespace App\Repositories;

use App\Models\HrProject;
use App\Repositories\Interfaces\HrProjectRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class HrProjectRepository implements HrProjectRepositoryInterface
{
    /**
     * Get all HR projects with relationships.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        // return HrProject::with( 'tasks')->get();
        return HrProject::all();
    }

    /**
     * Get a specific HR project by ID.
     *
     * @param int $id
     * @return HrProject|null
     */
    public function findById(int $id): ?HrProject
    {
        // return HrProject::with('tasks')->find($id);
        return HrProject::find($id);
    }

    /**
     * Create a new HR project.
     *
     * @param array $data
     * @return HrProject
     */
    public function create(array $data): HrProject
    {
        return HrProject::create($data);
    }

    /**
     * Update an existing HR project.
     *
     * @param int $id
     * @param array $data
     * @return HrProject|null
     */
    public function update(int $id, array $data): ?HrProject
    {
        $hrProject = HrProject::find($id);

        if (!$hrProject) {
            return null;
        }

        $hrProject->update($data);
        return $hrProject->fresh();
    }

    /**
     * Delete an HR project.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $hrProject = HrProject::find($id);

        if (!$hrProject) {
            return false;
        }

        return $hrProject->delete();
    }


    /**
     * Get HR projects by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        // return HrProject::with('tasks')
        //     ->where('status', $status)
        //     ->get();

        return HrProject::where('status', $status)->get();
    }

    /**
     * Get HR projects by priority.
     *
     * @param string $priority
     * @return Collection
     */
    public function getByPriority(string $priority): Collection
    {
        // return HrProject::with( 'tasks')
        //     ->where('priority', $priority)
        //     ->get();
        return HrProject::where('priority', $priority)->get();

    }

    /**
     * Get HR projects with upcoming due dates.
     *
     * @param int $days
     * @return Collection
     */
    public function getUpcomingDueDates(int $days): Collection
    {
        $today = Carbon::today();
        $future = Carbon::today()->addDays($days);

        // return HrProject::with('tasks')
        //     ->whereBetween('due_date', [$today, $future])
        //     ->orderBy('due_date')
        //     ->get();

        return HrProject::whereBetween('due_date', [$today, $future])
            ->orderBy('due_date')
            ->get();
    }
}
