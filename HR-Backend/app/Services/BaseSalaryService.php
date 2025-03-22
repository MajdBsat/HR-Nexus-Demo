<?php

namespace App\Services;

use App\Models\BaseSalary;
use App\Repositories\Interfaces\BaseSalaryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class BaseSalaryService
{
    /**
     * The base salary repository instance.
     *
     * @var BaseSalaryRepositoryInterface
     */
    protected $baseSalaryRepository;

    /**
     * Create a new service instance.
     *
     * @param BaseSalaryRepositoryInterface $baseSalaryRepository
     * @return void
     */
    public function __construct(BaseSalaryRepositoryInterface $baseSalaryRepository)
    {
        $this->baseSalaryRepository = $baseSalaryRepository;
    }

    /**
     * Get all base salary records.
     *
     * @return Collection
     */
    public function getAllBaseSalaries(): Collection
    {
        return $this->baseSalaryRepository->getAll();
    }

    /**
     * Get base salary record by ID.
     *
     * @param int $id
     * @return BaseSalary|null
     */
    public function getBaseSalaryById(int $id): ?BaseSalary
    {
        return $this->baseSalaryRepository->findById($id);
    }

    /**
     * Create a new base salary record.
     *
     * @param array $data
     * @return array
     */
    public function createBaseSalary(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id|unique:base_salaries,user_id',
            'amount' => 'required|numeric|min:0',
            'effective_date' => 'required|date',
            'currency' => 'required|string|max:3',
            'remarks' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $baseSalary = $this->baseSalaryRepository->create($data);

        return [
            'success' => true,
            'message' => 'Base salary record created successfully',
            'data' => $baseSalary
        ];
    }

    /**
     * Update a base salary record.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateBaseSalary(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'sometimes|integer|exists:users,id|unique:base_salaries,user_id,' . $id,
            'amount' => 'sometimes|numeric|min:0',
            'effective_date' => 'sometimes|date',
            'currency' => 'sometimes|string|max:3',
            'remarks' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $baseSalary = $this->baseSalaryRepository->update($id, $data);

        if (!$baseSalary) {
            return [
                'success' => false,
                'message' => 'Base salary record not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Base salary record updated successfully',
            'data' => $baseSalary
        ];
    }

    /**
     * Delete a base salary record.
     *
     * @param int $id
     * @return array
     */
    public function deleteBaseSalary(int $id): array
    {
        $result = $this->baseSalaryRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Base salary record not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Base salary record deleted successfully'
        ];
    }

    /**
     * Get base salary record by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getBaseSalaryByUserId(int $userId): array
    {
        if (!$this->baseSalaryRepository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $baseSalary = $this->baseSalaryRepository->findByUserId($userId);

        if (!$baseSalary) {
            return [
                'success' => false,
                'message' => 'Base salary record not found for this user'
            ];
        }

        return [
            'success' => true,
            'data' => $baseSalary
        ];
    }
}
