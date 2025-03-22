<?php

namespace App\Services;

use App\Models\MonthlyPayroll;
use App\Repositories\Interfaces\MonthlyPayrollRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class MonthlyPayrollService
{
    /**
     * The monthly payroll repository instance.
     *
     * @var MonthlyPayrollRepositoryInterface
     */
    protected $monthlyPayrollRepository;

    /**
     * Create a new service instance.
     *
     * @param MonthlyPayrollRepositoryInterface $monthlyPayrollRepository
     * @return void
     */
    public function __construct(MonthlyPayrollRepositoryInterface $monthlyPayrollRepository)
    {
        $this->monthlyPayrollRepository = $monthlyPayrollRepository;
    }

    /**
     * Get all monthly payrolls.
     *
     * @return Collection
     */
    public function getAllMonthlyPayrolls(): Collection
    {
        return $this->monthlyPayrollRepository->getAll();
    }

    /**
     * Get monthly payroll by ID.
     *
     * @param int $id
     * @return MonthlyPayroll|null
     */
    public function getMonthlyPayrollById(int $id): ?MonthlyPayroll
    {
        return $this->monthlyPayrollRepository->findById($id);
    }

    /**
     * Create a new monthly payroll.
     *
     * @param array $data
     * @return array
     */
    public function createMonthlyPayroll(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id',
            'department_id' => 'nullable|integer|exists:departments,id',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:2100',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'numeric|min:0',
            'deductions' => 'numeric|min:0',
            'bonus' => 'numeric|min:0',
            'overtime_hours' => 'numeric|min:0',
            'overtime_rate' => 'numeric|min:0',
            'overtime_pay' => 'numeric|min:0',
            'tax' => 'numeric|min:0',
            'net_salary' => 'required|numeric|min:0',
            'gross_salary' => 'required|numeric|min:0',
            'benefits' => 'nullable|json',
            'deduction_details' => 'nullable|json',
            'allowance_details' => 'nullable|json',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
            'status' => 'required|string|in:Pending,Approved,Paid,Cancelled',
            'notes' => 'nullable|string',
            'created_by' => 'nullable|integer|exists:users,id',
            'approved_by' => 'nullable|integer|exists:users,id',
            'approved_at' => 'nullable|date',
            'metadata' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        if (!$this->monthlyPayrollRepository->userExists($data['user_id'])) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        if (isset($data['department_id']) && !$this->monthlyPayrollRepository->departmentExists($data['department_id'])) {
            return [
                'success' => false,
                'message' => 'Department not found'
            ];
        }

        // Check if payroll for this user, month, and year already exists
        $existingPayrolls = $this->monthlyPayrollRepository->getByMonthYear($data['month'], $data['year']);
        foreach ($existingPayrolls as $payroll) {
            if ($payroll->user_id == $data['user_id']) {
                return [
                    'success' => false,
                    'message' => 'Payroll for this user, month, and year already exists'
                ];
            }
        }

        $monthlyPayroll = $this->monthlyPayrollRepository->create($data);

        return [
            'success' => true,
            'message' => 'Monthly payroll created successfully',
            'data' => $monthlyPayroll
        ];
    }

    /**
     * Update a monthly payroll.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateMonthlyPayroll(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'sometimes|integer|exists:users,id',
            'department_id' => 'nullable|integer|exists:departments,id',
            'month' => 'sometimes|integer|min:1|max:12',
            'year' => 'sometimes|integer|min:2000|max:2100',
            'basic_salary' => 'sometimes|numeric|min:0',
            'allowances' => 'numeric|min:0',
            'deductions' => 'numeric|min:0',
            'bonus' => 'numeric|min:0',
            'overtime_hours' => 'numeric|min:0',
            'overtime_rate' => 'numeric|min:0',
            'overtime_pay' => 'numeric|min:0',
            'tax' => 'numeric|min:0',
            'net_salary' => 'sometimes|numeric|min:0',
            'gross_salary' => 'sometimes|numeric|min:0',
            'benefits' => 'nullable|json',
            'deduction_details' => 'nullable|json',
            'allowance_details' => 'nullable|json',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
            'status' => 'sometimes|string|in:Pending,Approved,Paid,Cancelled',
            'notes' => 'nullable|string',
            'created_by' => 'nullable|integer|exists:users,id',
            'approved_by' => 'nullable|integer|exists:users,id',
            'approved_at' => 'nullable|date',
            'metadata' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        if (isset($data['user_id']) && !$this->monthlyPayrollRepository->userExists($data['user_id'])) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        if (isset($data['department_id']) && !$this->monthlyPayrollRepository->departmentExists($data['department_id'])) {
            return [
                'success' => false,
                'message' => 'Department not found'
            ];
        }

        // Check for duplicate if changing user, month, or year
        $existingPayroll = $this->monthlyPayrollRepository->findById($id);
        if ($existingPayroll) {
            $month = $data['month'] ?? $existingPayroll->month;
            $year = $data['year'] ?? $existingPayroll->year;
            $userId = $data['user_id'] ?? $existingPayroll->user_id;

            if ($month != $existingPayroll->month || $year != $existingPayroll->year || $userId != $existingPayroll->user_id) {
                $existingPayrolls = $this->monthlyPayrollRepository->getByMonthYear($month, $year);
                foreach ($existingPayrolls as $payroll) {
                    if ($payroll->user_id == $userId && $payroll->id != $id) {
                        return [
                            'success' => false,
                            'message' => 'Payroll for this user, month, and year already exists'
                        ];
                    }
                }
            }
        }

        $monthlyPayroll = $this->monthlyPayrollRepository->update($id, $data);

        if (!$monthlyPayroll) {
            return [
                'success' => false,
                'message' => 'Monthly payroll not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Monthly payroll updated successfully',
            'data' => $monthlyPayroll
        ];
    }

    /**
     * Delete a monthly payroll.
     *
     * @param int $id
     * @return array
     */
    public function deleteMonthlyPayroll(int $id): array
    {
        $result = $this->monthlyPayrollRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Monthly payroll not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Monthly payroll deleted successfully'
        ];
    }

    /**
     * Get monthly payrolls by month and year.
     *
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getMonthlyPayrollsByMonthYear(int $month, int $year): array
    {
        $monthlyPayrolls = $this->monthlyPayrollRepository->getByMonthYear($month, $year);

        return [
            'success' => true,
            'data' => $monthlyPayrolls
        ];
    }

    /**
     * Get monthly payrolls by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getMonthlyPayrollsByUserId(int $userId): array
    {
        if (!$this->monthlyPayrollRepository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $monthlyPayrolls = $this->monthlyPayrollRepository->getByUserId($userId);

        return [
            'success' => true,
            'data' => $monthlyPayrolls
        ];
    }

    /**
     * Get monthly payrolls by status.
     *
     * @param string $status
     * @return array
     */
    public function getMonthlyPayrollsByStatus(string $status): array
    {
        $monthlyPayrolls = $this->monthlyPayrollRepository->getByStatus($status);

        return [
            'success' => true,
            'data' => $monthlyPayrolls
        ];
    }

    /**
     * Get monthly payrolls by department ID.
     *
     * @param int $departmentId
     * @return array
     */
    public function getMonthlyPayrollsByDepartmentId(int $departmentId): array
    {
        if (!$this->monthlyPayrollRepository->departmentExists($departmentId)) {
            return [
                'success' => false,
                'message' => 'Department not found'
            ];
        }

        $monthlyPayrolls = $this->monthlyPayrollRepository->getByDepartmentId($departmentId);

        return [
            'success' => true,
            'data' => $monthlyPayrolls
        ];
    }

    /**
     * Get monthly payrolls by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getMonthlyPayrollsByDateRange(string $startDate, string $endDate): array
    {
        $monthlyPayrolls = $this->monthlyPayrollRepository->getByDateRange($startDate, $endDate);

        return [
            'success' => true,
            'data' => $monthlyPayrolls
        ];
    }

    /**
     * Get the total payroll amount for a specific month and year.
     *
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getTotalPayrollAmount(int $month, int $year): array
    {
        $totalAmount = $this->monthlyPayrollRepository->getTotalPayrollAmount($month, $year);

        return [
            'success' => true,
            'data' => [
                'month' => $month,
                'year' => $year,
                'total_amount' => $totalAmount
            ]
        ];
    }

    /**
     * Approve a monthly payroll.
     *
     * @param int $id
     * @param int $approvedBy
     * @return array
     */
    public function approveMonthlyPayroll(int $id, int $approvedBy): array
    {
        $monthlyPayroll = $this->monthlyPayrollRepository->findById($id);

        if (!$monthlyPayroll) {
            return [
                'success' => false,
                'message' => 'Monthly payroll not found'
            ];
        }

        if ($monthlyPayroll->status !== 'Pending') {
            return [
                'success' => false,
                'message' => 'Only pending payrolls can be approved'
            ];
        }

        if (!$this->monthlyPayrollRepository->userExists($approvedBy)) {
            return [
                'success' => false,
                'message' => 'Approver user not found'
            ];
        }

        $data = [
            'status' => 'Approved',
            'approved_by' => $approvedBy,
            'approved_at' => now()
        ];

        $updatedPayroll = $this->monthlyPayrollRepository->update($id, $data);

        return [
            'success' => true,
            'message' => 'Monthly payroll approved successfully',
            'data' => $updatedPayroll
        ];
    }

    /**
     * Mark a monthly payroll as paid.
     *
     * @param int $id
     * @param array $paymentDetails
     * @return array
     */
    public function markMonthlyPayrollAsPaid(int $id, array $paymentDetails): array
    {
        $validator = Validator::make($paymentDetails, [
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $monthlyPayroll = $this->monthlyPayrollRepository->findById($id);

        if (!$monthlyPayroll) {
            return [
                'success' => false,
                'message' => 'Monthly payroll not found'
            ];
        }

        if ($monthlyPayroll->status !== 'Approved') {
            return [
                'success' => false,
                'message' => 'Only approved payrolls can be marked as paid'
            ];
        }

        $data = array_merge($paymentDetails, ['status' => 'Paid']);
        $updatedPayroll = $this->monthlyPayrollRepository->update($id, $data);

        return [
            'success' => true,
            'message' => 'Monthly payroll marked as paid successfully',
            'data' => $updatedPayroll
        ];
    }

    /**
     * Cancel a monthly payroll.
     *
     * @param int $id
     * @param string $notes
     * @return array
     */
    public function cancelMonthlyPayroll(int $id, string $notes = null): array
    {
        $monthlyPayroll = $this->monthlyPayrollRepository->findById($id);

        if (!$monthlyPayroll) {
            return [
                'success' => false,
                'message' => 'Monthly payroll not found'
            ];
        }

        if ($monthlyPayroll->status === 'Paid') {
            return [
                'success' => false,
                'message' => 'Paid payrolls cannot be cancelled'
            ];
        }

        $data = [
            'status' => 'Cancelled',
        ];

        if ($notes) {
            $data['notes'] = $notes;
        }

        $updatedPayroll = $this->monthlyPayrollRepository->update($id, $data);

        return [
            'success' => true,
            'message' => 'Monthly payroll cancelled successfully',
            'data' => $updatedPayroll
        ];
    }
}
