<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'manager_id',
    ];

    /**
     * Get the manager that owns the department.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get the users that belong to the department.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
