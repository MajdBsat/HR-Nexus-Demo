<?php

namespace App\Services;

use App\Models\Candidate;
use App\Repositories\Interfaces\CandidateRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CandidateService
{
    /**
     * The candidate repository instance.
     *
     * @var CandidateRepositoryInterface
     */
    protected $candidateRepository;
    protected $userService;


    /**
     * Create a new service instance.
     *
     * @param CandidateRepositoryInterface $candidateRepository
     * @return void
     */
    public function __construct(CandidateRepositoryInterface $candidateRepository,
                                UserService $userService    )
    {
        $this->candidateRepository = $candidateRepository;
        $this->userService = $userService;
    }

    /**
     * Get all candidates.
     *
     * @return Collection
     */
    public function getAllCandidates(): Collection
    {
        return $this->candidateRepository->getAll();
    }

    /**
     * Get candidate by ID.
     *
     * @param int $id
     * @return Candidate|null
     */
    public function getCandidateById(int $id): ?Candidate
    {
        return $this->candidateRepository->findById($id);
    }

    public function getCandidatebyUserID($user_id){
        return $this->candidateRepository->getCandidatebyUserID($user_id);
    }
    public function findByUserIDandJobID(int $user_id ,int $job_id){
        return $this->candidateRepository->findByUserIDandJobID($user_id, $job_id);
    }
    /**
     * Create a new candidate.
     *
     * @param array $data
     * @return array
     */
    public function createCandidate(array $data): array
    {
        $validator = Validator::make($data, [
            'status' => 'nullable|in:applied,interviewed,hired,rejected',
            'job_id' => 'required|integer|exists:jobs,id',
            // 'user_id' => 'required|integer|exists:users,id'
        ]);
        $user=Auth::user();
        $data["user_id"]=$user["id"];
        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $candidate = $this->candidateRepository->create($data);
        if(!$candidate){
            return [
                'success' => false,
                'message' => 'Already Applied',
                'errors' => 'Already Applied'
            ];
        }
        return [
            'success' => true,
            'message' => 'Candidate created successfully',
            'data' => $candidate
        ];
    }

    /**
     * Update a candidate.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateCandidate(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'status' => 'required|in:applied,interviewed,hired,rejected',
            'job_id' => 'required|integer|exists:jobs,id',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $candidate = $this->candidateRepository->update($id, $data);

        if (!$candidate) {
            return [
                'success' => false,
                'message' => 'Candidate not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Candidate updated successfully',
            'data' => $candidate
        ];
    }



    /**
     * Delete a candidate.
     *
     * @param int $id
     * @return array
     */
    public function deleteCandidate(int $id): array
    {
        $result = $this->candidateRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Candidate not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Candidate deleted successfully'
        ];
    }

    public function updateCandidateStatus(int $id): array
    {
        $candidate = $this->candidateRepository->findById($id);
        if (!$candidate) {
            return [
                'success' => false,
                'message' => 'Candidate not found'
            ];
        }
        if($candidate['status'] == 'applied'){
            $new_candidate = $this->candidateRepository->update($id,["status"=>"interviewed"]);
        }

        if($candidate['status'] == 'interviewed'){
            $this->candidateRepository->update($id,["status"=>"hired"]);
            $this->userService->updateUser($candidate['user']['id'], ["user_type"=>1]);
            $this->candidateRepository->delete($id);
        }

        return [
            'success' => true,
            'message' => 'Candidate updated successfully',
            'data' => $new_candidate? $new_candidate : $candidate
        ];
    }

    public function updateCandidateReject(int $id): array
    {
        $candidate = $this->candidateRepository->findById($id);
        if (!$candidate) {
            return [
                'success' => false,
                'message' => 'Candidate not found'
            ];
        }
        $this->candidateRepository->update($id,["status"=>"rejected"]);

        return [
            'success' => true,
            'message' => 'Candidate updated successfully',
            'data' => $candidate
        ];
    }

    /**
     * Get candidates by position.
     *
     * @param string $position
     * @return array
     */
    // public function getCandidatesByPosition(string $position): array
    // {
    //     $candidates = $this->candidateRepository->getByPosition($position);

    //     return [
    //         'success' => true,
    //         'data' => $candidates
    //     ];
    // }

    /**
     * Get candidates by status.
     *
     * @param string $status
     * @return array
     */
    public function getCandidatesByStatus(string $status): array
    {
        $validator = Validator::make(['status' => $status], [
            'status' => 'required|in:applied,screening,interview,offered,hired,rejected',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $candidates = $this->candidateRepository->getByStatus($status);

        return [
            'success' => true,
            'data' => $candidates
        ];
    }

    /**
     * Search candidates by name or email.
     *
     * @param string $searchTerm
     * @return array
     */
    public function searchCandidates(string $searchTerm): array
    {
        if (empty($searchTerm) || strlen($searchTerm) < 2) {
            return [
                'success' => false,
                'message' => 'Search term must be at least 2 characters long'
            ];
        }

        $candidates = $this->candidateRepository->search($searchTerm);

        return [
            'success' => true,
            'data' => $candidates
        ];
    }
}
