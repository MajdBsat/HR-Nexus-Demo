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
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use App\Repositories\Interfaces\BaseSalaryRepositoryInterface;
use App\Repositories\Interfaces\BenefitPlanRepositoryInterface;
use App\Repositories\Interfaces\CandidateRepositoryInterface;
use App\Repositories\Interfaces\ComplianceRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use App\Repositories\Interfaces\HrProjectTaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
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
