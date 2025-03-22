<?php

namespace App\Services;

use App\Models\InsurancePlan;
use App\Repositories\Interfaces\InsurancePlanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class InsurancePlanService
{
    /**
     * The insurance plan repository instance.
     *
     * @var InsurancePlanRepositoryInterface
     */
    protected $insurancePlanRepository;

    /**
     * Create a new service instance.
     *
     * @param InsurancePlanRepositoryInterface $insurancePlanRepository
     * @return void
     */
    public function __construct(InsurancePlanRepositoryInterface $insurancePlanRepository)
    {
        $this->insurancePlanRepository = $insurancePlanRepository;
    }

    /**
     * Get all insurance plans.
     *
     * @return Collection
     */
    public function getAllInsurancePlans(): Collection
    {
        return $this->insurancePlanRepository->getAll();
    }

    /**
     * Get insurance plan by ID.
     *
     * @param int $id
     * @return InsurancePlan|null
     */
    public function getInsurancePlanById(int $id): ?InsurancePlan
    {
        return $this->insurancePlanRepository->findById($id);
    }

    /**
     * Create a new insurance plan.
     *
     * @param array $data
     * @return array
     */
    public function createInsurancePlan(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id',
            'plan_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:50',
            'provider' => 'required|string|max:100',
            'policy_number' => 'nullable|string|max:50',
            'coverage_details' => 'nullable|json',
            'premium_amount' => 'required|numeric|min:0',
            'deductible_amount' => 'required|numeric|min:0',
            'coverage_limit' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'renewal_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,pending,expired',
            'beneficiaries' => 'nullable|json',
            'documents' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $insurancePlan = $this->insurancePlanRepository->create($data);

        return [
            'success' => true,
            'message' => 'Insurance plan created successfully',
            'data' => $insurancePlan
        ];
    }

    /**
     * Update an insurance plan.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateInsurancePlan(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'sometimes|integer|exists:users,id',
            'plan_name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|string|max:50',
            'provider' => 'sometimes|string|max:100',
            'policy_number' => 'nullable|string|max:50',
            'coverage_details' => 'nullable|json',
            'premium_amount' => 'sometimes|numeric|min:0',
            'deductible_amount' => 'sometimes|numeric|min:0',
            'coverage_limit' => 'nullable|numeric|min:0',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after:start_date',
            'renewal_date' => 'nullable|date',
            'status' => 'sometimes|in:active,inactive,pending,expired',
            'beneficiaries' => 'nullable|json',
            'documents' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $insurancePlan = $this->insurancePlanRepository->update($id, $data);

        if (!$insurancePlan) {
            return [
                'success' => false,
                'message' => 'Insurance plan not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Insurance plan updated successfully',
            'data' => $insurancePlan
        ];
    }

    /**
     * Delete an insurance plan.
     *
     * @param int $id
     * @return array
     */
    public function deleteInsurancePlan(int $id): array
    {
        $result = $this->insurancePlanRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Insurance plan not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Insurance plan deleted successfully'
        ];
    }

    /**
     * Get insurance plans by type.
     *
     * @param string $type
     * @return array
     */
    public function getInsurancePlansByType(string $type): array
    {
        $insurancePlans = $this->insurancePlanRepository->getByType($type);

        return [
            'success' => true,
            'data' => $insurancePlans
        ];
    }

    /**
     * Get insurance plans by status.
     *
     * @param string $status
     * @return array
     */
    public function getInsurancePlansByStatus(string $status): array
    {
        $insurancePlans = $this->insurancePlanRepository->getByStatus($status);

        return [
            'success' => true,
            'data' => $insurancePlans
        ];
    }

    /**
     * Get insurance plans by provider.
     *
     * @param string $provider
     * @return array
     */
    public function getInsurancePlansByProvider(string $provider): array
    {
        $insurancePlans = $this->insurancePlanRepository->getByProvider($provider);

        return [
            'success' => true,
            'data' => $insurancePlans
        ];
    }

    /**
     * Get active insurance plans.
     *
     * @return array
     */
    public function getActiveInsurancePlans(): array
    {
        $activePlans = $this->insurancePlanRepository->getActivePlans();

        return [
            'success' => true,
            'data' => $activePlans
        ];
    }

    /**
     * Get insurance plans by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getInsurancePlansByUserId(int $userId): array
    {
        if (!$this->insurancePlanRepository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $insurancePlans = $this->insurancePlanRepository->getByUserId($userId);

        return [
            'success' => true,
            'data' => $insurancePlans
        ];
    }
}
