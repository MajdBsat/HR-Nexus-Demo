<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingTask extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'employee_id',
        'role_id',
        'task_id',
    ];

    /**
     * Get the employee for the onboarding task.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get the role for the onboarding task.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the task for the onboarding task.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
