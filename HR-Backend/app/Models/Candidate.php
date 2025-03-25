<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'job_id',
        'user_id',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'job_id' => 'integer',
            'user_id' => 'integer',
            'status' => 'string'
        ];
    }

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
