<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

   
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'dob',
        'phone_nb',
        'user_type',
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
}
