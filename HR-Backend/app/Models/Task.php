<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'task_type',
        'status',
        'priority',
        'due_date',
        'assigned_date',
        'review',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'date',
        'assigned_date' => 'date',
        'review' => 'integer',
    ];

    /**
     * Get the HR projects for the task.
     */
    public function hrProjects(): BelongsToMany
    {
        return $this->belongsToMany(HrProject::class, 'hr_project_tasks');
    }

    /**
     * Get the onboarding tasks for the task.
     */
    public function onboardingTasks(): HasMany
    {
        return $this->hasMany(OnboardingTask::class);
    }
}
