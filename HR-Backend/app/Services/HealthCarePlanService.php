<?php

namespace App\Services;

use App\Models\HealthCarePlan;
use App\Repositories\Interfaces\HealthCarePlanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class HealthCarePlanService
{
    /**
     * The health care plan repository instance.
     *
     * @var HealthCarePlanRepositoryInterface
     */
    protected $healthCarePlanRepository;

    /**
     * Create a new service instance.
     *
     * @param HealthCarePlanRepositoryInterface $healthCarePlanRepository
     * @return void
     */
    public function __construct(HealthCarePlanRepositoryInterface $healthCarePlanRepository)
    {
        $this->healthCarePlanRepository = $healthCarePlanRepository;
    }

    /**
     * Get all health care plans.
     *
     * @return Collection
     */
    public function getAllHealthCarePlans(): Collection
    {
        return $this->healthCarePlanRepository->getAll();
    }

    /**
     * Get health care plan by ID.
     *
     * @param int $id
     * @return HealthCarePlan|null
     */
    public function getHealthCarePlanById(int $id): ?HealthCarePlan
    {
        return $this->healthCarePlanRepository->findById($id);
    }

    /**
     * Create a new health care plan.
     *
     * @param array $data
     * @return array
     */
    public function createHealthCarePlan(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id',
            'plan_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'provider' => 'required|string|max:100',
            'coverage_type' => 'required|string|max:50',
            'coverage_details' => 'nullable|json',
            'premium_amount' => 'required|numeric|min:0',
            'deductible_amount' => 'required|numeric|min:0',
            'copay_amount' => 'required|numeric|min:0',
            'enrollment_date' => 'required|date',
            'effective_date' => 'required|date|after_or_equal:enrollment_date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'status' => 'required|in:active,inactive,pending,expired',
            'dependents' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $healthCarePlan = $this->healthCarePlanRepository->create($data);

        return [
            'success' => true,
            'message' => 'Health care plan created successfully',
            'data' => $healthCarePlan
        ];
    }

    /**
     * Update a health care plan.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateHealthCarePlan(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'sometimes|integer|exists:users,id',
            'plan_name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'provider' => 'sometimes|string|max:100',
            'coverage_type' => 'sometimes|string|max:50',
            'coverage_details' => 'nullable|json',
            'premium_amount' => 'sometimes|numeric|min:0',
            'deductible_amount' => 'sometimes|numeric|min:0',
            'copay_amount' => 'sometimes|numeric|min:0',
            'enrollment_date' => 'sometimes|date',
            'effective_date' => 'sometimes|date|after_or_equal:enrollment_date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'status' => 'sometimes|in:active,inactive,pending,expired',
            'dependents' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $healthCarePlan = $this->healthCarePlanRepository->update($id, $data);

        if (!$healthCarePlan) {
            return [
                'success' => false,
                'message' => 'Health care plan not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Health care plan updated successfully',
            'data' => $healthCarePlan
        ];
    }

    /**
     * Delete a health care plan.
     *
     * @param int $id
     * @return array
     */
    public function deleteHealthCarePlan(int $id): array
    {
        $result = $this->healthCarePlanRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Health care plan not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Health care plan deleted successfully'
        ];
    }

    /**
     * Get health care plans by coverage type.
     *
     * @param string $coverageType
     * @return array
     */
    public function getHealthCarePlansByCoverageType(string $coverageType): array
    {
        $healthCarePlans = $this->healthCarePlanRepository->getByCoverageType($coverageType);

        return [
            'success' => true,
            'data' => $healthCarePlans
        ];
    }

    /**
     * Get active health care plans.
     *
     * @return array
     */
    public function getActiveHealthCarePlans(): array
    {
        $activePlans = $this->healthCarePlanRepository->getActivePlans();

        return [
            'success' => true,
            'data' => $activePlans
        ];
    }

    /**
     * Get health care plans by provider.
     *
     * @param string $provider
     * @return array
     */
    public function getHealthCarePlansByProvider(string $provider): array
    {
        $healthCarePlans = $this->healthCarePlanRepository->getByProvider($provider);

        return [
            'success' => true,
            'data' => $healthCarePlans
        ];
    }

    /**
     * Get health care plans by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getHealthCarePlansByUserId(int $userId): array
    {
        if (!$this->healthCarePlanRepository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $healthCarePlans = $this->healthCarePlanRepository->getByUserId($userId);

        return [
            'success' => true,
            'data' => $healthCarePlans
        ];
    }
}
