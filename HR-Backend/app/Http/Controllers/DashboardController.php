<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getGenderDistribution()
    {
        $distribution = User::select('gender', DB::raw('count(*) as count'))
            ->groupBy('gender')
            ->get();

        return response()->json($distribution);
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

    public function getAttendanceStats()
    {
        $stats = Attendance::select(
            DB::raw('DATE_FORMAT(date, "%Y-%m") as month'),
            DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present'),
            DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($stats);
    }
}
