<?php

namespace App\Providers;

use App\Repositories\AttendanceRepository;
use App\Repositories\BaseSalaryRepository;
use App\Repositories\BenefitPlanRepository;
use App\Repositories\CandidateRepository;
use App\Repositories\ComplianceRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\HrProjectTaskRepository;
use App\Repositories\AuthRepository;
use App\Repositories\DesignationRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\HealthCarePlanRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\PayrollRepository;
use App\Repositories\TodoRepository;
use App\Repositories\HrProjectRepository;
use App\Repositories\InsurancePlanRepository;
use App\Repositories\JobApplicationRepository;
use App\Repositories\MonthlyPayrollRepository;
use App\Repositories\OnboardingTaskRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TaskRepository;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use App\Repositories\Interfaces\BaseSalaryRepositoryInterface;
use App\Repositories\Interfaces\BenefitPlanRepositoryInterface;
use App\Repositories\Interfaces\CandidateRepositoryInterface;
use App\Repositories\Interfaces\ComplianceRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use App\Repositories\Interfaces\HrProjectTaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\DesignationRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\HealthCarePlanRepositoryInterface;
use App\Repositories\Interfaces\OrganizationRepositoryInterface;
use App\Repositories\Interfaces\PayrollRepositoryInterface;
use App\Repositories\Interfaces\TodoRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\HrProjectRepositoryInterface;
use App\Repositories\Interfaces\InsurancePlanRepositoryInterface;
use App\Repositories\Interfaces\JobApplicationRepositoryInterface;
use App\Repositories\Interfaces\MonthlyPayrollRepositoryInterface;
use App\Repositories\Interfaces\OnboardingTaskRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            HrProjectTaskRepositoryInterface::class,
            HrProjectTaskRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            DepartmentRepositoryInterface::class,
            DepartmentRepository::class
        );

        $this->app->bind(
            AttendanceRepositoryInterface::class,
            AttendanceRepository::class
        );

        $this->app->bind(
            BaseSalaryRepositoryInterface::class,
            BaseSalaryRepository::class
        );

        $this->app->bind(
            BenefitPlanRepositoryInterface::class,
            BenefitPlanRepository::class
        );

        $this->app->bind(
            CandidateRepositoryInterface::class,
            CandidateRepository::class
        );

        $this->app->bind(
            ComplianceRepositoryInterface::class,
            ComplianceRepository::class
        );

        $this->app->bind(
            DocumentRepositoryInterface::class,
            DocumentRepository::class
        );

        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(DesignationRepositoryInterface::class, DesignationRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
        $this->app->bind(OrganizationRepositoryInterface::class, OrganizationRepository::class);
        $this->app->bind(PayrollRepositoryInterface::class, PayrollRepository::class);
        $this->app->bind(HealthCarePlanRepositoryInterface::class, HealthCarePlanRepository::class);
        $this->app->bind(HrProjectRepositoryInterface::class, HrProjectRepository::class);
        $this->app->bind(InsurancePlanRepositoryInterface::class, InsurancePlanRepository::class);
        $this->app->bind(JobApplicationRepositoryInterface::class, JobApplicationRepository::class);
        $this->app->bind(MonthlyPayrollRepositoryInterface::class, MonthlyPayrollRepository::class);
        $this->app->bind(OnboardingTaskRepositoryInterface::class, OnboardingTaskRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
