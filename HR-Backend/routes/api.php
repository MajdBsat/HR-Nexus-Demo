<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BaseSalaryController;
use App\Http\Controllers\BenefitPlanController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HrProjectController;
use App\Http\Controllers\HrProjectTaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InsurancePlanController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\MonthlyPayrollController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OnboardingTaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthCarePlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication routes - public
Route::get('jobs/', [JobController::class, 'index']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Protected authentication routes
    Route::group(['middleware' => ['auth.api']], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// Public routes
Route::get('jobs', [JobController::class, 'index']); // Available to everyone
// Guest routes - User type 0
Route::group(['middleware' => ['jwt', 'role:guest']], function () {
    Route::get('jobs/{id}', [JobController::class, 'show']);
    Route::post('candidates/', [CandidateController::class, 'store']);
});

// Employee routes - User type 1
Route::group(['middleware' => ['jwt', 'role:employee']], function () {

    // Task routes
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::get('/{id}', [TaskController::class, 'show'])->where('id', '[0-9]+');

        // Additional specialized routes
        Route::get('/status/{status}', [TaskController::class, 'getByStatus']);
        Route::get('/priority/{priority}', [TaskController::class, 'getByPriority']);
        Route::get('/user/{userId}', [TaskController::class, 'getByUserId'])->where('userId', '[0-9]+');
        Route::put('/next/{id}', [TaskController::class, 'nextStep']);
        Route::get('/upcoming/{days?}', [TaskController::class, 'getUpcomingTasks'])->where('days', '[0-9]+');
    });

    // Job Applications
    Route::get('job-applications', [JobApplicationController::class, 'index']);
    Route::get('job-applications/{id}', [JobApplicationController::class, 'show']);
    Route::post('job-applications', [JobApplicationController::class, 'store']);
    Route::put('job-applications/{id}', [JobApplicationController::class, 'update']);
    Route::delete('job-applications/{id}', [JobApplicationController::class, 'destroy']);

    // Insurance Plans
    Route::get('insurance-plans', [InsurancePlanController::class, 'index']);
    Route::get('insurance-plans/{id}', [InsurancePlanController::class, 'show']);

    // Health Care Plans
    Route::get('healthcare-plans', [HealthCarePlanController::class, 'index']);
    Route::get('healthcare-plans/{id}', [HealthCarePlanController::class, 'show']);

    // Documents
    Route::get('documents', [DocumentController::class, 'index']);
    Route::get('documents/{id}', [DocumentController::class, 'show']);
    Route::post('documents', [DocumentController::class, 'store']);
    Route::put('documents/{id}', [DocumentController::class, 'update']);
    Route::delete('documents/{id}', [DocumentController::class, 'destroy']);

    // Benefit Plans
    Route::get('benefit-plans', [BenefitPlanController::class, 'index']);
    Route::get('benefit-plans/{id}', [BenefitPlanController::class, 'show']);
});

// HR routes - User type 2
Route::group(['middleware' => ['jwt', 'role:hr']], function () {
    // Insurance Plans - additional operations
    Route::post('insurance-plans', [InsurancePlanController::class, 'store']);
    Route::put('insurance-plans/{id}', [InsurancePlanController::class, 'update']);
    Route::delete('insurance-plans/{id}', [InsurancePlanController::class, 'destroy']);

    // Health Care Plans - additional operations
    Route::post('healthcare-plans', [HealthCarePlanController::class, 'store']);
    Route::put('healthcare-plans/{id}', [HealthCarePlanController::class, 'update']);
    Route::delete('healthcare-plans/{id}', [HealthCarePlanController::class, 'destroy']);

    // Benefit Plans - additional operations
    Route::post('benefit-plans', [BenefitPlanController::class, 'store']);
    Route::put('benefit-plans/{id}', [BenefitPlanController::class, 'update']);
    Route::delete('benefit-plans/{id}', [BenefitPlanController::class, 'destroy']);

    // Roles
    Route::get('roles', [RoleController::class, 'index']);
    Route::get('roles/{id}', [RoleController::class, 'show']);
    Route::post('roles', [RoleController::class, 'store']);
    Route::put('roles/{id}', [RoleController::class, 'update']);
    Route::delete('roles/{id}', [RoleController::class, 'destroy']);
    Route::get('roles/{id}/tasks', [RoleController::class, 'getTasks']);

    // Job Routes
    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'index']);
        Route::get('/{id}', [JobController::class, 'show'])->where('id', '[0-9]+');
        Route::post('/search', [JobController::class, 'search']);
    });

    // Task routes
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::get('/{id}', [TaskController::class, 'show'])->where('id', '[0-9]+');
        Route::put('/{id}', [TaskController::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [TaskController::class, 'destroy'])->where('id', '[0-9]+');

        // Additional specialized routes
        Route::get('/status/{status}', [TaskController::class, 'getByStatus']);
        Route::get('/priority/{priority}', [TaskController::class, 'getByPriority']);
        Route::get('/user/{userId}', [TaskController::class, 'getByUserId'])->where('userId', '[0-9]+');
        Route::put('/next/{id}', [TaskController::class, 'nextStep']);
        Route::put('/reject/{id}', [TaskController::class, 'reject']);
        Route::get('/upcoming/{days?}', [TaskController::class, 'getUpcomingTasks'])->where('days', '[0-9]+');
    });


    // Candidate routes
    Route::prefix('candidates')->group(function () {
        Route::get('/', [CandidateController::class, 'index']);
        Route::post('/', [CandidateController::class, 'store']);
        Route::get('/{id}', [CandidateController::class, 'show']);
        Route::put('/{id}', [CandidateController::class, 'update']);
        Route::delete('/{id}', [CandidateController::class, 'destroy']);

        // Additional specialized routes
        Route::get('/status/{status}', [CandidateController::class, 'getByStatus']);
        Route::post('/search', [CandidateController::class, 'search']);
        Route::put('/next/{id}', [CandidateController::class, 'nextStep']);
        Route::put('/reject/{id}', [CandidateController::class, 'reject']);
});
});

// User routes
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show'])->where('id', '[0-9]+');
    Route::put('/{id}', [UserController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/{id}', [UserController::class, 'destroy'])->where('id', '[0-9]+');
});

// Department routes
Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::post('/', [DepartmentController::class, 'store']);
    Route::get('/{id}', [DepartmentController::class, 'show'])->where('id', '[0-9]+');
    Route::put('/{id}', [DepartmentController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/{id}', [DepartmentController::class, 'destroy'])->where('id', '[0-9]+');
});

// Attendance routes
Route::prefix('attendances')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/', [AttendanceController::class, 'store']);
    Route::get('/{id}', [AttendanceController::class, 'show']);
    Route::put('/{id}', [AttendanceController::class, 'update']);
    Route::delete('/{id}', [AttendanceController::class, 'destroy']);

    // Additional specialized routes
    Route::get('/user/{userId}', [AttendanceController::class, 'getByUserId']);
    Route::post('/date-range', [AttendanceController::class, 'getByDateRange']);
});

// Base Salary routes
Route::prefix('base-salaries')->group(function () {
    Route::get('/', [BaseSalaryController::class, 'index']);
    Route::post('/', [BaseSalaryController::class, 'store']);
    Route::get('/{id}', [BaseSalaryController::class, 'show']);
    Route::put('/{id}', [BaseSalaryController::class, 'update']);
    Route::delete('/{id}', [BaseSalaryController::class, 'destroy']);

    // Additional specialized route
    Route::get('/user/{userId}', [BaseSalaryController::class, 'getByUserId']);
});

// Benefit Plan routes
Route::prefix('benefit-plans')->group(function () {
    Route::get('/', [BenefitPlanController::class, 'index']);
    Route::post('/', [BenefitPlanController::class, 'store']);
    Route::get('/{id}', [BenefitPlanController::class, 'show']);
    Route::put('/{id}', [BenefitPlanController::class, 'update']);
    Route::delete('/{id}', [BenefitPlanController::class, 'destroy']);

    // Additional specialized routes
    Route::get('/user/{userId}', [BenefitPlanController::class, 'getByUserId']);
    Route::get('/active', [BenefitPlanController::class, 'getActivePlans']);
});

// Compliance routes
Route::prefix('compliance')->group(function () {
    Route::get('/', [ComplianceController::class, 'index']);
    Route::post('/', [ComplianceController::class, 'store']);
    Route::get('/{id}', [ComplianceController::class, 'show']);
    Route::put('/{id}', [ComplianceController::class, 'update']);
    Route::delete('/{id}', [ComplianceController::class, 'destroy']);

    // Additional specialized routes
    Route::get('/user/{userId}', [ComplianceController::class, 'getByUserId']);
    Route::get('/status/{status}', [ComplianceController::class, 'getByStatus']);
    Route::get('/type/{type}', [ComplianceController::class, 'getByType']);
    Route::get('/expiring', [ComplianceController::class, 'getExpiring']);
});

// Document routes
Route::prefix('documents')->group(function () {
    Route::get('/', [DocumentController::class, 'index']);
    Route::post('/', [DocumentController::class, 'store']);
    Route::get('/{id}', [DocumentController::class, 'show']);
    Route::put('/{id}', [DocumentController::class, 'update']);
    Route::delete('/{id}', [DocumentController::class, 'destroy']);

    // Additional specialized routes
    Route::get('/user/{userId}', [DocumentController::class, 'getByUserId']);
    Route::get('/category/{category}', [DocumentController::class, 'getByCategory']);
    Route::get('/type/{documentType}', [DocumentController::class, 'getByType']);
    Route::post('/search', [DocumentController::class, 'search']);
});



Route::group(['middleware' => 'auth:api'], function () {
    // Health Care Plan routes
    Route::apiResource('health-care-plans', \App\Http\Controllers\HealthCarePlanController::class);
    Route::get('health-care-plans/coverage-type/{coverageType}', [\App\Http\Controllers\HealthCarePlanController::class, 'getByCoverageType']);
    Route::get('health-care-plans/active', [\App\Http\Controllers\HealthCarePlanController::class, 'getActivePlans']);
    Route::get('health-care-plans/provider/{provider}', [\App\Http\Controllers\HealthCarePlanController::class, 'getByProvider']);
    Route::get('health-care-plans/user/{userId}', [\App\Http\Controllers\HealthCarePlanController::class, 'getByUserId']);
});

// Insurance Plan Routes
Route::prefix('insurance-plans')->group(function () {
    Route::get('/', [InsurancePlanController::class, 'index']);
    Route::post('/', [InsurancePlanController::class, 'store']);
    Route::get('/{id}', [InsurancePlanController::class, 'show'])->where('id', '[0-9]+');
    Route::put('/{id}', [InsurancePlanController::class, 'update'])->where('id', '[0-9]+');
    Route::delete('/{id}', [InsurancePlanController::class, 'destroy'])->where('id', '[0-9]+');
    Route::get('/type/{type}', [InsurancePlanController::class, 'getByType']);
    Route::get('/status/{status}', [InsurancePlanController::class, 'getByStatus']);
    Route::get('/provider/{provider}', [InsurancePlanController::class, 'getByProvider']);
    Route::get('/active', [InsurancePlanController::class, 'getActivePlans']);
    Route::get('/user/{userId}', [InsurancePlanController::class, 'getByUserId'])->where('userId', '[0-9]+');
});

// Job Application Routes
// Route::prefix('job-applications')->group(function () {
//     Route::get('/', [JobApplicationController::class, 'index']);
//     Route::post('/', [JobApplicationController::class, 'store']);
//     Route::get('/{id}', [JobApplicationController::class, 'show'])->where('id', '[0-9]+');
//     Route::put('/{id}', [JobApplicationController::class, 'update'])->where('id', '[0-9]+');
//     Route::delete('/{id}', [JobApplicationController::class, 'destroy'])->where('id', '[0-9]+');
//     Route::get('/job/{jobId}', [JobApplicationController::class, 'getByJobId'])->where('jobId', '[0-9]+');
//     Route::get('/user/{userId}', [JobApplicationController::class, 'getByUserId'])->where('userId', '[0-9]+');
//     Route::get('/status/{status}', [JobApplicationController::class, 'getByStatus']);
//     Route::post('/date-range', [JobApplicationController::class, 'getByDateRange']);
//     Route::get('/recent/{days?}', [JobApplicationController::class, 'getRecent'])->where('days', '[0-9]+');
// });

// MonthlyPayroll routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('monthly-payrolls', [MonthlyPayrollController::class, 'index']);
    Route::post('monthly-payrolls', [MonthlyPayrollController::class, 'store']);
    Route::get('monthly-payrolls/{id}', [MonthlyPayrollController::class, 'show']);
    Route::put('monthly-payrolls/{id}', [MonthlyPayrollController::class, 'update']);
    Route::delete('monthly-payrolls/{id}', [MonthlyPayrollController::class, 'destroy']);

    // Additional monthly payroll routes
    Route::get('monthly-payrolls/month-year/{month}/{year}', [MonthlyPayrollController::class, 'getByMonthYear']);
    Route::get('monthly-payrolls/user/{userId}', [MonthlyPayrollController::class, 'getByUserId']);
    Route::get('monthly-payrolls/status/{status}', [MonthlyPayrollController::class, 'getByStatus']);
    Route::get('monthly-payrolls/department/{departmentId}', [MonthlyPayrollController::class, 'getByDepartmentId']);
    Route::post('monthly-payrolls/date-range', [MonthlyPayrollController::class, 'getByDateRange']);
    Route::get('monthly-payrolls/total/{month}/{year}', [MonthlyPayrollController::class, 'getTotalPayrollAmount']);
    Route::post('monthly-payrolls/{id}/approve', [MonthlyPayrollController::class, 'approvePayroll']);
    Route::post('monthly-payrolls/{id}/mark-paid', [MonthlyPayrollController::class, 'markAsPaid']);
    Route::post('monthly-payrolls/{id}/cancel', [MonthlyPayrollController::class, 'cancelPayroll']);
});



// Role routes
Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);

    // Additional specialized routes
    Route::get('/{id}/tasks', [RoleController::class, 'getTasks']);
});

// Profile routes
Route::group(['middleware' => ['auth.api']], function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
});

// Dashboard routes
Route::group(['middleware' => ['auth.api']], function () {
    Route::get('/departments/stats', [DashboardController::class, 'getDepartmentStats']);
    Route::get('/users/type-distribution', [DashboardController::class, 'getUserTypeDistribution']);
    Route::get('/users/growth', [DashboardController::class, 'getEmployeeGrowth']);
    Route::get('/attendance/hours', [DashboardController::class, 'getAttendanceHoursStats']);
    Route::get('/attendance/locations', [DashboardController::class, 'getAttendanceLocationStats']);
    Route::get('/jobs/stats', [DashboardController::class, 'getJobStats']);
    Route::get('/job-applications/stats', [DashboardController::class, 'getJobApplicationsStats']);
    Route::get('/projects/stats', [DashboardController::class, 'getProjectStats']);
    Route::get('/onboarding/progress', [DashboardController::class, 'getOnboardingProgress']);
    Route::get('/departments/managers', [DashboardController::class, 'getDepartmentManagerStats']);
    Route::get('/tasks/completion', [DashboardController::class, 'getTaskCompletionStats']);
});









// =============Mohammad Zeineddine====================
// // Candidate routes
// Route::prefix('candidates')->group(function () {
//     Route::get('/', [CandidateController::class, 'index']);
//     Route::post('/', [CandidateController::class, 'store']);
//     Route::get('/{id}', [CandidateController::class, 'show']);
//     Route::put('/{id}', [CandidateController::class, 'update']);
//     Route::delete('/{id}', [CandidateController::class, 'destroy']);
//     // Additional specialized routes
//     Route::get('/status/{status}', [CandidateController::class, 'getByStatus']);
//     Route::post('/search', [CandidateController::class, 'search']);
//     Route::put('/next/{id}', [CandidateController::class, 'nextStep']);
//     Route::put('/reject/{id}', [CandidateController::class, 'reject']);
// });

// // Task routes
// Route::prefix('tasks')->group(function () {
//     Route::get('/', [TaskController::class, 'index']);
//     Route::post('/', [TaskController::class, 'store']);
//     Route::get('/{id}', [TaskController::class, 'show'])->where('id', '[0-9]+');
//     Route::put('/{id}', [TaskController::class, 'update'])->where('id', '[0-9]+');
//     Route::delete('/{id}', [TaskController::class, 'destroy'])->where('id', '[0-9]+');
//     // Additional specialized routes
//     Route::get('/status/{status}', [TaskController::class, 'getByStatus']);
//     Route::get('/priority/{priority}', [TaskController::class, 'getByPriority']);
//     Route::get('/user/{userId}', [TaskController::class, 'getByUserId'])->where('userId', '[0-9]+');
//     Route::put('/next/{id}', [TaskController::class, 'nextStep']);
//     Route::put('/reject/{id}', [TaskController::class, 'reject']);
//     Route::get('/upcoming/{days?}', [TaskController::class, 'getUpcomingTasks'])->where('days', '[0-9]+');
// });

// // Job Routes
// Route::prefix('jobs')->group(function () {
//     Route::get('/', [JobController::class, 'index']);
//     Route::post('/', [JobController::class, 'store']);
//     Route::get('/{id}', [JobController::class, 'show'])->where('id', '[0-9]+');
//     Route::put('/{id}', [JobController::class, 'update'])->where('id', '[0-9]+');
//     Route::delete('/{id}', [JobController::class, 'destroy'])->where('id', '[0-9]+');
//     Route::post('/search', [JobController::class, 'search']);
// });

// Onboarding Task routes
// Route::prefix('onboarding-tasks')->group(function () {
//     Route::get('/', [OnboardingTaskController::class, 'index']);
//     Route::post('/', [OnboardingTaskController::class, 'store']);
//     Route::get('/{id}', [OnboardingTaskController::class, 'show']);
//     Route::put('/{id}', [OnboardingTaskController::class, 'update']);
//     Route::delete('/{id}', [OnboardingTaskController::class, 'destroy']);
//     // Additional specialized routes
//     Route::get('/employee/{employeeId}', [OnboardingTaskController::class, 'getByEmployeeId']);
// });

// HR Project routes
Route::prefix('hr-projects')->group(function () {
    Route::get('/', [HrProjectController::class, 'index']);
    Route::post('/', [HrProjectController::class, 'store']);
    Route::get('/{id}', [HrProjectController::class, 'show']);
    Route::put('/{id}', [HrProjectController::class, 'update']);
    Route::delete('/{id}', [HrProjectController::class, 'destroy']);

    // Additional specialized routes
    Route::get('/status/{status}', [HrProjectController::class, 'getByStatus']);
    Route::get('/priority/{priority}', [HrProjectController::class, 'getByPriority']);
    Route::get('/upcoming/{days?}', [HrProjectController::class, 'getUpcomingProjects']);
});

// HR Project Task routes
Route::prefix('hr-project-tasks')->group(function () {
    Route::get('/', [HrProjectTaskController::class, 'index']);
    Route::post('/', [HrProjectTaskController::class, 'store']);
    Route::get('/{id}', [HrProjectTaskController::class, 'show']);
    Route::delete('/{id}', [HrProjectTaskController::class, 'destroy']);

    // Additional specialized routes
    Route::get('/project/{projectId}/tasks', [HrProjectTaskController::class, 'getProjectTasks']);
    Route::get('/task/{taskId}/projects', [HrProjectTaskController::class, 'getTaskProjects']);
    Route::put('/next/{id}', [TaskController::class, 'nextStep']);
    Route::put('/reject/{id}', [TaskController::class, 'reject']);
});
