<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsurancePlan extends Model
{
    use HasFactory;


    protected $fillable = [
        'benefit_plan_id',
        'insurance_type',
        'details',
        'description',
        'price',
    ];

   
    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Get the benefit plan that owns the insurance plan.
     */
    public function benefitPlan(): BelongsTo
    {
        return $this->belongsTo(BenefitPlan::class);
    }
}
