<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'responsibilities',
        'requirements',
        'qualifications',
        'location',
        'department',
        'job_type',
        'job_level',
        'salary_min',
        'salary_max',
        'salary_currency',
        'salary_period',
        'is_remote',
        'posting_date',
        'closing_date',
        'status',
        'posted_by',
        'hiring_manager_id',
        'vacancies',
        'benefits',
        'skills',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'is_remote' => 'boolean',
        'posting_date' => 'date',
        'closing_date' => 'date',
        'vacancies' => 'integer',
        'benefits' => 'array',
        'skills' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Get the user who posted the job.
     *
     * @return BelongsTo
     */
    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Get the hiring manager for the job.
     *
     * @return BelongsTo
     */
    public function hiringManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'hiring_manager_id');
    }

    /**
     * Get the job applications for the job.
     *
     * @return HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Scope a query to only include jobs with a specific status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include jobs in a specific department.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $department
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope a query to only include jobs of a specific type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $jobType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByJobType($query, $jobType)
    {
        return $query->where('job_type', $jobType);
    }

    /**
     * Scope a query to only include active job postings.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Published')
            ->where(function ($query) {
                $query->whereNull('closing_date')
                    ->orWhere('closing_date', '>=', now()->toDateString());
            });
    }

    /**
     * Scope a query to filter jobs by location.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $location
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    /**
     * Scope a query to filter jobs by remote status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param bool $isRemote
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByRemoteStatus($query, $isRemote)
    {
        return $query->where('is_remote', $isRemote);
    }
}
