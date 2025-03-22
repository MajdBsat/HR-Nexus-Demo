<?php

use App\Http\Controllers\HrProjectTaskController;
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
