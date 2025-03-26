<?php

namespace App\Services;

use App\Models\Attendance;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class AttendanceService
{
    /**
     * The attendance repository instance.
     *
     * @var AttendanceRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param AttendanceRepositoryInterface $repository
     * @return void
     */
    public function __construct(AttendanceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all attendance records.
     *
     * @return Collection
     */
    public function getAllAttendances(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Get attendance record by ID.
     *
     * @param int $id
     * @return Attendance|null
     */
    public function getAttendanceById(int $id): ?Attendance
    {
        return $this->repository->findById($id);
    }

    /**
     * Create a new attendance record.
     *
     * @param array $data
     * @return array
     */
    public function createAttendance(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id',
            'attendance_date' => 'required|date',
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'break_in' => 'nullable|date_format:H:i',
            'break_out' => 'nullable|date_format:H:i|after:break_in',
            // 'status' => 'required|in:present,absent,late,half_day,leave',
            // 'remarks' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }


        $attendance = $this->repository->create($data);

        return [
            'success' => true,
            'message' => 'Attendance record created successfully',
            'data' => $attendance
        ];
    }

    /**
     * Update an attendance record.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateAttendance(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            // 'user_id' => 'sometimes|integer|exists:users,id',
            'attendance_date' => 'sometimes|date',
            'clock_in' => 'sometimes|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'break_in' => 'nullable|date_format:H:i',
            'break_out' => 'nullable|date_format:H:i|after:break_in',
            // 'status' => 'sometimes|in:present,absent,late,half_day,leave',
            // 'remarks' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $attendance = $this->repository->update($id, $data);

        if (!$attendance) {
            return [
                'success' => false,
                'message' => 'Attendance record not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Attendance record updated successfully',
            'data' => $attendance
        ];
    }

    /**
     * Delete an attendance record.
     *
     * @param int $id
     * @return array
     */
    public function deleteAttendance(int $id): array
    {
        $result = $this->repository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Attendance record not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Attendance record deleted successfully'
        ];
    }

    /**
     * Get attendance records by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getAttendanceByUserId(int $userId): array
    {
        if (!$this->repository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $attendances = $this->repository->getByUserId($userId);

        return [
            'success' => true,
            'data' => $attendances
        ];
    }

    /**
     * Get attendance records by date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @param int|null $userId
     * @return array
     */
    public function getAttendanceByDateRange(string $startDate, string $endDate, ?int $userId = null): array
    {
        $validator = Validator::make([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => $userId,
        ], [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $attendances = $this->repository->getByDateRange($startDate, $endDate, $userId);

        return [
            'success' => true,
            'data' => $attendances
        ];
    }
}
