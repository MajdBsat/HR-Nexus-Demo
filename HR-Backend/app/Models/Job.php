<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'description',
        'requirement',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'title' => 'string',
            'description' =>'string',
            'requirement'=> 'string',
        ];
    }

    /**
     * Get the candidates of the job.
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }


}
