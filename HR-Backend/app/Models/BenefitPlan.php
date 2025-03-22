<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BenefitPlan extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'benefit_plan_name',
    ];

    /**
     * Get the health care plans associated with the benefit plan.
     */
    public function healthCarePlans(): HasMany
    {
        return $this->hasMany(HealthCarePlan::class);
    }

    /**
     * Get the insurance plans associated with the benefit plan.
     */
    public function insurancePlans(): HasMany
    {
        return $this->hasMany(InsurancePlan::class);
    }
}
