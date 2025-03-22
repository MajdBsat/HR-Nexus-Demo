<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BaseSalaryController;
use App\Http\Controllers\BenefitPlanController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HrProjectTaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User routes
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

// Department routes
Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::post('/', [DepartmentController::class, 'store']);
    Route::get('/{id}', [DepartmentController::class, 'show']);
    Route::put('/{id}', [DepartmentController::class, 'update']);
    Route::delete('/{id}', [DepartmentController::class, 'destroy']);
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

// Candidate routes
Route::prefix('candidates')->group(function () {
    Route::get('/', [CandidateController::class, 'index']);
    Route::post('/', [CandidateController::class, 'store']);
    Route::get('/{id}', [CandidateController::class, 'show']);
    Route::put('/{id}', [CandidateController::class, 'update']);
    Route::delete('/{id}', [CandidateController::class, 'destroy']);

    // Additional specialized routes
    Route::get('/position/{position}', [CandidateController::class, 'getByPosition']);
    Route::get('/status/{status}', [CandidateController::class, 'getByStatus']);
    Route::post('/search', [CandidateController::class, 'search']);
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

// HR Project Task routes
Route::prefix('hr-project-tasks')->group(function () {
    Route::get('/', [HrProjectTaskController::class, 'index']);
    Route::post('/', [HrProjectTaskController::class, 'store']);
    Route::get('/{id}', [HrProjectTaskController::class, 'show']);
    Route::delete('/{id}', [HrProjectTaskController::class, 'destroy']);

    // Additional specialized routes
    Route::get('/project/{projectId}/tasks', [HrProjectTaskController::class, 'getProjectTasks']);
    Route::get('/task/{taskId}/projects', [HrProjectTaskController::class, 'getTaskProjects']);
});
