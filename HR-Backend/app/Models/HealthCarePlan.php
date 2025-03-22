<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthCarePlan extends Model
{
    use HasFactory;


    protected $fillable = [
        'benefit_plan_id',
        'plan_name',
        'details',
        'price',
    ];


    protected $casts = [
        'price' => 'decimal:2',
    ];

    
    public function benefitPlan(): BelongsTo
    {
        return $this->belongsTo(BenefitPlan::class);
    }
}
