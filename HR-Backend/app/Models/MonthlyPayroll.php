<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyPayroll extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'payroll_month',
        'bonus',
        'penalty',
        'final_pay',
        'description',
    ];

  
    protected $casts = [
        'payroll_month' => 'date',
        'bonus' => 'decimal:2',
        'penalty' => 'decimal:2',
        'final_pay' => 'decimal:2',
    ];

    /**
     * Get the user that owns the monthly payroll.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
