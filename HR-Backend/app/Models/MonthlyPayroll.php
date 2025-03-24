<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyPayroll extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'department_id',
        'month',
        'year',
        'basic_salary',
        'allowances',
        'deductions',
        'bonus',
        'overtime_hours',
        'overtime_rate',
        'overtime_pay',
        'tax',
        'net_salary',
        'gross_salary',
        'benefits',
        'deduction_details',
        'allowance_details',
        'payment_date',
        'payment_method',
        'payment_reference',
        'status',
        'notes',
        'created_by',
        'approved_by',
        'approved_at',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'deductions' => 'decimal:2',
        'bonus' => 'decimal:2',
        'overtime_hours' => 'decimal:2',
        'overtime_rate' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'tax' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'benefits' => 'array',
        'deduction_details' => 'array',
        'allowance_details' => 'array',
        'payment_date' => 'date',
        'approved_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user that the payroll belongs to.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department that the payroll belongs to.
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user who created the payroll.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved the payroll.
     *
     * @return BelongsTo
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope a query to only include payrolls for a specific month and year.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $month
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByMonthYear($query, $month, $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }

    /**
     * Scope a query to only include payrolls for a specific user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include payrolls with a specific status.
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
     * Scope a query to only include payrolls for a specific department.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $departmentId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Scope a query to filter payrolls by date range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereDate('payment_date', '>=', $startDate)
                     ->whereDate('payment_date', '<=', $endDate);
    }
}
