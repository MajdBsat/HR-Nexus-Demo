<?php

namespace App\Services;

use App\Models\Compliance;
use App\Repositories\Interfaces\ComplianceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class ComplianceService
{
    /**
     * The compliance repository instance.
     *
     * @var ComplianceRepositoryInterface
     */
    protected $complianceRepository;

    /**
     * Create a new service instance.
     *
     * @param ComplianceRepositoryInterface $complianceRepository
     * @return void
     */
    public function __construct(ComplianceRepositoryInterface $complianceRepository)
    {
        $this->complianceRepository = $complianceRepository;
    }

    /**
     * Get all compliance records.
     *
     * @return Collection
     */
    public function getAllCompliance(): Collection
    {
        return $this->complianceRepository->getAll();
    }

    /**
     * Get compliance record by ID.
     *
     * @param int $id
     * @return Compliance|null
     */
    public function getComplianceById(int $id): ?Compliance
    {
        return $this->complianceRepository->findById($id);
    }

    /**
     * Create a new compliance record.
     *
     * @param array $data
     * @return array
     */
    public function createCompliance(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'compliance_type' => 'required|string|max:100',
            'status' => 'required|in:pending,completed,expired,waived',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'completion_date' => 'nullable|date|after_or_equal:issue_date',
            'document_path' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $compliance = $this->complianceRepository->create($data);

        return [
            'success' => true,
            'message' => 'Compliance record created successfully',
            'data' => $compliance
        ];
    }

    /**
     * Update a compliance record.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateCompliance(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'sometimes|integer|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'compliance_type' => 'sometimes|string|max:100',
            'status' => 'sometimes|in:pending,completed,expired,waived',
            'issue_date' => 'sometimes|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'completion_date' => 'nullable|date|after_or_equal:issue_date',
            'document_path' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $compliance = $this->complianceRepository->update($id, $data);

        if (!$compliance) {
            return [
                'success' => false,
                'message' => 'Compliance record not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Compliance record updated successfully',
            'data' => $compliance
        ];
    }

    /**
     * Delete a compliance record.
     *
     * @param int $id
     * @return array
     */
    public function deleteCompliance(int $id): array
    {
        $result = $this->complianceRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Compliance record not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Compliance record deleted successfully'
        ];
    }

    /**
     * Get compliance records by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getComplianceByUserId(int $userId): array
    {
        if (!$this->complianceRepository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $complianceRecords = $this->complianceRepository->getByUserId($userId);

        return [
            'success' => true,
            'data' => $complianceRecords
        ];
    }

    /**
     * Get compliance records by status.
     *
     * @param string $status
     * @return array
     */
    public function getComplianceByStatus(string $status): array
    {
        $validator = Validator::make(['status' => $status], [
            'status' => 'required|in:pending,completed,expired,waived',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $complianceRecords = $this->complianceRepository->getByStatus($status);

        return [
            'success' => true,
            'data' => $complianceRecords
        ];
    }

    /**
     * Get compliance records by type.
     *
     * @param string $type
     * @return array
     */
    public function getComplianceByType(string $type): array
    {
        $complianceRecords = $this->complianceRepository->getByType($type);

        return [
            'success' => true,
            'data' => $complianceRecords
        ];
    }

    /**
     * Get expiring compliance records.
     *
     * @param int $daysToExpire
     * @return array
     */
    public function getExpiringCompliance(int $daysToExpire = 30): array
    {
        if ($daysToExpire < 1) {
            return [
                'success' => false,
                'message' => 'Days to expire must be at least 1'
            ];
        }

        $complianceRecords = $this->complianceRepository->getExpiringRecords($daysToExpire);

        return [
            'success' => true,
            'data' => $complianceRecords
        ];
    }
}
