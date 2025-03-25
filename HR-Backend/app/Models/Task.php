<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'status',
        'priority',
        'assigned_to',
        'due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assigned_to'=>'integer',
        'due_date' => 'date',
    ];

    /**
     * Get the user that the task is assigned to.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the HR projects that this task belongs to.
     */
    public function hrProjects(): BelongsToMany
    {
        return $this->belongsToMany(HrProject::class, 'hr_project_tasks');
    }

    /**
     * Scope a query to only include tasks with a specific status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include tasks with a specific priority.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $priority
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to only include tasks assigned to a specific user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByAssignedUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * Scope a query to only include tasks due within a specific number of days.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query, $days)
    {
        $today = now();
        $future = now()->addDays($days);

        return $query->whereBetween('due_date', [$today, $future])
            ->orderBy('due_date');
    }

    /**
     * Get the onboarding tasks for the task.
     */
    public function onboardingTasks(): HasMany
    {
        return $this->hasMany(OnboardingTask::class);
    }
}
