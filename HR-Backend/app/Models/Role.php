<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'title',
        'description',
        'requirements',
    ];

    /**
     * Get the onboarding tasks for the role.
     */
    public function onboardingTasks(): HasMany
    {
        return $this->hasMany(OnboardingTask::class);
    }
}
