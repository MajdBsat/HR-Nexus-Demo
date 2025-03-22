<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthCarePlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'plan_name',
        'description',
        'provider',
        'coverage_type',
        'coverage_details',
        'premium_amount',
        'deductible_amount',
        'copay_amount',
        'enrollment_date',
        'effective_date',
        'expiry_date',
        'status',
        'dependents',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'premium_amount' => 'decimal:2',
        'deductible_amount' => 'decimal:2',
        'copay_amount' => 'decimal:2',
        'enrollment_date' => 'date',
        'effective_date' => 'date',
        'expiry_date' => 'date',
        'coverage_details' => 'json',
        'dependents' => 'json',
    ];

    /**
     * Get the user that owns the health care plan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active health care plans.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include health care plans of a specific coverage type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $coverageType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCoverageType($query, $coverageType)
    {
        return $query->where('coverage_type', $coverageType);
    }

    /**
     * Scope a query to only include health care plans from a specific provider.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }
}
