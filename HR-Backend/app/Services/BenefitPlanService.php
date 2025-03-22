<?php

namespace App\Services;

use App\Models\BenefitPlan;
use App\Repositories\Interfaces\BenefitPlanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class BenefitPlanService
{
    /**
     * The benefit plan repository instance.
     *
     * @var BenefitPlanRepositoryInterface
     */
    protected $benefitPlanRepository;

    /**
     * Create a new service instance.
     *
     * @param BenefitPlanRepositoryInterface $benefitPlanRepository
     * @return void
     */
    public function __construct(BenefitPlanRepositoryInterface $benefitPlanRepository)
    {
        $this->benefitPlanRepository = $benefitPlanRepository;
    }

    /**
     * Get all benefit plans.
     *
     * @return Collection
     */
    public function getAllBenefitPlans(): Collection
    {
        return $this->benefitPlanRepository->getAll();
    }

    /**
     * Get benefit plan by ID.
     *
     * @param int $id
     * @return BenefitPlan|null
     */
    public function getBenefitPlanById(int $id): ?BenefitPlan
    {
        return $this->benefitPlanRepository->findById($id);
    }

    /**
     * Create a new benefit plan.
     *
     * @param array $data
     * @return array
     */
    public function createBenefitPlan(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:users,id',
            'plan_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'coverage_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,pending',
            'plan_type' => 'required|string|max:50',
            'details' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $benefitPlan = $this->benefitPlanRepository->create($data);

        return [
            'success' => true,
            'message' => 'Benefit plan created successfully',
            'data' => $benefitPlan
        ];
    }

    /**
     * Update a benefit plan.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateBenefitPlan(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'sometimes|integer|exists:users,id',
            'plan_name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'coverage_amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:active,inactive,pending',
            'plan_type' => 'sometimes|string|max:50',
            'details' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $benefitPlan = $this->benefitPlanRepository->update($id, $data);

        if (!$benefitPlan) {
            return [
                'success' => false,
                'message' => 'Benefit plan not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Benefit plan updated successfully',
            'data' => $benefitPlan
        ];
    }

    /**
     * Delete a benefit plan.
     *
     * @param int $id
     * @return array
     */
    public function deleteBenefitPlan(int $id): array
    {
        $result = $this->benefitPlanRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Benefit plan not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Benefit plan deleted successfully'
        ];
    }

    /**
     * Get benefit plans by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getBenefitPlansByUserId(int $userId): array
    {
        if (!$this->benefitPlanRepository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $benefitPlans = $this->benefitPlanRepository->getByUserId($userId);

        return [
            'success' => true,
            'data' => $benefitPlans
        ];
    }

    /**
     * Get active benefit plans.
     *
     * @return array
     */
    public function getActiveBenefitPlans(): array
    {
        $activePlans = $this->benefitPlanRepository->getActivePlans();

        return [
            'success' => true,
            'data' => $activePlans
        ];
    }
}
