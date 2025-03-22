<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Get the candidates for the job.
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }
}
