<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Task;
use App\Models\HrProject;
use App\Models\OnboardingTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getDepartmentStats()
    {
        $stats = Department::withCount('users')->get()
            ->map(function ($department) {
                return [
                    'name' => $department->name,
                    'count' => $department->users_count
                ];
            });

        return response()->json($stats);
    }

    public function getUserTypeDistribution()
    {
        $distribution = User::select('user_type', DB::raw('count(*) as count'))
            ->groupBy('user_type')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => $this->getUserTypeName($item->user_type),
                    'count' => $item->count
                ];
            });

        return response()->json($distribution);
    }

    private function getUserTypeName($type)
    {
        switch ($type) {
            case 0: return 'Guest';
            case 1: return 'Employee';
            case 2: return 'HR';
            default: return 'Unknown';
        }
    }

    public function getEmployeeGrowth()
    {
        $growth = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as date'),
            DB::raw('count(*) as count')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($growth);
    }

    public function getAttendanceHoursStats()
    {
        $stats = Attendance::select(
            DB::raw('DATE_FORMAT(date_of_attendance, "%Y-%m-%d") as day'),
            DB::raw('AVG(total_hours) as average_hours')
        )
            ->groupBy('day')
            ->orderBy('day')
            ->limit(30)
            ->get();

        return response()->json($stats);
    }

    public function getAttendanceLocationStats()
    {
        $locations = Attendance::select('location', DB::raw('count(*) as count'))
            ->groupBy('location')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json($locations);
    }

    public function getJobStats()
    {
        $stats = Job::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json($stats);
    }

    public function getJobApplicationsStats()
    {
        $stats = JobApplication::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json($stats);
    }

    public function getProjectStats()
    {
        $stats = HrProject::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json($stats);
    }

    public function getOnboardingProgress()
    {
        $stats = OnboardingTask::select('employee_id', DB::raw('count(*) as total'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed'))
            ->groupBy('employee_id')
            ->with('employee:id,name')
            ->limit(10)
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->employee ? $item->employee->name : 'Unknown',
                    'completed' => $item->completed,
                    'total' => $item->total,
                    'percentage' => $item->total > 0 ? round(($item->completed / $item->total) * 100) : 0
                ];
            });

        return response()->json($stats);
    }

    public function getDepartmentManagerStats()
    {
        $stats = Department::with('manager:id,name')
            ->get()
            ->map(function($department) {
                return [
                    'department' => $department->name,
                    'manager' => $department->manager ? $department->manager->name : 'Unassigned'
                ];
            });

        return response()->json($stats);
    }

    public function getTaskCompletionStats()
    {
        $now = Carbon::now();
        $thirtyDaysAgo = $now->copy()->subDays(30);

        $stats = Task::where('created_at', '>=', $thirtyDaysAgo)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
                DB::raw('count(*) as total'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function($item) {
                return [
                    'date' => $item->date,
                    'completed' => $item->completed,
                    'pending' => $item->total - $item->completed
                ];
            });

        return response()->json($stats);
    }
}
