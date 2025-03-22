<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaseSalary extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'salary',
        'fixed_bonus',
        'effective_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'salary' => 'decimal:2',
        'fixed_bonus' => 'decimal:2',
        'effective_date' => 'date',
    ];

    /**
     * Get the user that owns the base salary.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
