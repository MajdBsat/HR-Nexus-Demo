<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\MonthlyPayroll;
use App\Models\User;
use App\Repositories\Interfaces\MonthlyPayrollRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MonthlyPayrollRepository implements MonthlyPayrollRepositoryInterface
{
    /**
     * Get all monthly payrolls.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return MonthlyPayroll::all();
    }

    /**
     * Find a monthly payroll by ID.
     *
     * @param int $id
     * @return MonthlyPayroll|null
     */
    public function findById(int $id): ?MonthlyPayroll
    {
        return MonthlyPayroll::find($id);
    }

    /**
     * Create a new monthly payroll.
     *
     * @param array $data
     * @return MonthlyPayroll
     */
    public function create(array $data): MonthlyPayroll
    {
        return MonthlyPayroll::create($data);
    }

    /**
     * Update a monthly payroll.
     *
     * @param int $id
     * @param array $data
     * @return MonthlyPayroll|null
     */
    public function update(int $id, array $data): ?MonthlyPayroll
    {
        $monthlyPayroll = $this->findById($id);

        if ($monthlyPayroll) {
            $monthlyPayroll->update($data);
            return $monthlyPayroll;
        }

        return null;
    }

    /**
     * Delete a monthly payroll.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $monthlyPayroll = $this->findById($id);

        if ($monthlyPayroll) {
            return $monthlyPayroll->delete();
        }

        return false;
    }

    /**
     * Get monthly payrolls by month and year.
     *
     * @param int $month
     * @param int $year
     * @return Collection
     */
    public function getByMonthYear(int $month, int $year): Collection
    {
        return MonthlyPayroll::byMonthYear($month, $year)->get();
    }

    /**
     * Get monthly payrolls by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return MonthlyPayroll::byUser($userId)->get();
    }

    /**
     * Get monthly payrolls by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        return MonthlyPayroll::byStatus($status)->get();
    }

    /**
     * Get monthly payrolls by department ID.
     *
     * @param int $departmentId
     * @return Collection
     */
    public function getByDepartmentId(int $departmentId): Collection
    {
        return MonthlyPayroll::byDepartment($departmentId)->get();
    }

    /**
     * Get monthly payrolls by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        return MonthlyPayroll::byDateRange($startDate, $endDate)->get();
    }

    /**
     * Check if a user exists.
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool
    {
        return User::where('id', $userId)->exists();
    }

    /**
     * Check if a department exists.
     *
     * @param int $departmentId
     * @return bool
     */
    public function departmentExists(int $departmentId): bool
    {
        return Department::where('id', $departmentId)->exists();
    }

    /**
     * Get the total payroll amount for a specific month and year.
     *
     * @param int $month
     * @param int $year
     * @return float
     */
    public function getTotalPayrollAmount(int $month, int $year): float
    {
        return MonthlyPayroll::byMonthYear($month, $year)->sum('net_salary');
    }
}
