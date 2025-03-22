<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HrProject extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'status',
        'priority',
        'due_date',
        'assigned_to',
    ];


    protected $casts = [
        'due_date' => 'date',
    ];

   
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the tasks for the HR project.
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'hr_project_tasks');
    }
}
