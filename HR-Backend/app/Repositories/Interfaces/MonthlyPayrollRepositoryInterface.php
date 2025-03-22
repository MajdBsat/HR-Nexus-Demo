<?php

namespace App\Repositories\Interfaces;

use App\Models\MonthlyPayroll;
use Illuminate\Database\Eloquent\Collection;

interface MonthlyPayrollRepositoryInterface
{
    /**
     * Get all monthly payrolls.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Find a monthly payroll by ID.
     *
     * @param int $id
     * @return MonthlyPayroll|null
     */
    public function findById(int $id): ?MonthlyPayroll;

    /**
     * Create a new monthly payroll.
     *
     * @param array $data
     * @return MonthlyPayroll
     */
    public function create(array $data): MonthlyPayroll;

    /**
     * Update a monthly payroll.
     *
     * @param int $id
     * @param array $data
     * @return MonthlyPayroll|null
     */
    public function update(int $id, array $data): ?MonthlyPayroll;

    /**
     * Delete a monthly payroll.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get monthly payrolls by month and year.
     *
     * @param int $month
     * @param int $year
     * @return Collection
     */
    public function getByMonthYear(int $month, int $year): Collection;

    /**
     * Get monthly payrolls by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection;

    /**
     * Get monthly payrolls by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection;

    /**
     * Get monthly payrolls by department ID.
     *
     * @param int $departmentId
     * @return Collection
     */
    public function getByDepartmentId(int $departmentId): Collection;

    /**
     * Get monthly payrolls by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function getByDateRange(string $startDate, string $endDate): Collection;

    /**
     * Check if a user exists.
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool;

    /**
     * Check if a department exists.
     *
     * @param int $departmentId
     * @return bool
     */
    public function departmentExists(int $departmentId): bool;

    /**
     * Get the total payroll amount for a specific month and year.
     *
     * @param int $month
     * @param int $year
     * @return float
     */
    public function getTotalPayrollAmount(int $month, int $year): float;
}
