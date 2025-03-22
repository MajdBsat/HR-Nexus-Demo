<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'job_id',
        'user_id',
        'status',
    ];

    /**
     * Get the job for the candidate.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the user for the candidate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
