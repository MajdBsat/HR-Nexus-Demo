<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'department_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date',
            'user_type' => 'integer',
        ];
    }

    /**
     * Get the managed department for the user.
     */
    public function managedDepartment()
    {
        return $this->hasOne(Department::class, 'manager_id');
    }

    /**
     * Get the base salary record for the user.
     */
    public function baseSalary()
    {
        return $this->hasOne(BaseSalary::class);
    }

    /**
     * Get the payrolls for the user.
     */
    public function monthlyPayrolls()
    {
        return $this->hasMany(MonthlyPayroll::class);
    }

    /**
     * Get the attendances for the user.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the documents for the user.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the assigned HR projects for the user.
     */
    public function assignedProjects()
    {
        return $this->hasMany(HrProject::class, 'assigned_to');
    }

    /**
     * Get the candidate records for the user.
     */
    public function candidateRecords()
    {
        return $this->hasMany(Candidate::class);
    }

    /**
     * Get the compliance records for the user.
     */
    public function compliances()
    {
        return $this->hasMany(Compliance::class);
    }

    /**
     * Get the onboarding tasks for the user.
     */
    public function onboardingTasks()
    {
        return $this->hasMany(OnboardingTask::class, 'employee_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user_type' => $this->user_type
        ];
    }

    /**
     * Check if user is a guest.
     *
     * @return bool
     */
    public function isGuest(): bool
    {
        return $this->user_type === 0;
    }

    /**
     * Check if user is an employee.
     *
     * @return bool
     */
    public function isEmployee(): bool
    {
        return $this->user_type === 1;
    }

    /**
     * Check if user is HR.
     *
     * @return bool
     */
    public function isHR(): bool
    {
        return $this->user_type === 2;
    }

    /**
     * Get the department that the user belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
