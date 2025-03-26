<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

   
    protected $fillable = [
        'user_id',
        'attendance_date',
        'location',
        'clock_in',
        'clock_out',
        'break_in',
        'break_out',
        'total_hours',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_attendance' => 'date',
        'clock_in_time' => 'datetime',
        'clock_out_time' => 'datetime',
        'total_hours' => 'decimal:2',
    ];

    /**
     * Get the user that owns the attendance.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
