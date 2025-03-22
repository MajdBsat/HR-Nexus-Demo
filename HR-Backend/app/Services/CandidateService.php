<?php

namespace App\Services;

use App\Models\Candidate;
use App\Repositories\Interfaces\CandidateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class CandidateService
{
    /**
     * The candidate repository instance.
     *
     * @var CandidateRepositoryInterface
     */
    protected $candidateRepository;

    /**
     * Create a new service instance.
     *
     * @param CandidateRepositoryInterface $candidateRepository
     * @return void
     */
    public function __construct(CandidateRepositoryInterface $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
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

    /**
     * Create a new candidate.
     *
     * @param array $data
     * @return array
     */
    public function createCandidate(array $data): array
    {
        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:candidates,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'resume_path' => 'nullable|string|max:255',
            'position' => 'required|string|max:100',
            'status' => 'required|in:applied,screening,interview,offered,hired,rejected',
            'skills' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'education' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'application_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $candidate = $this->candidateRepository->create($data);

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
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:candidates,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'resume_path' => 'nullable|string|max:255',
            'position' => 'sometimes|string|max:100',
            'status' => 'sometimes|in:applied,screening,interview,offered,hired,rejected',
            'skills' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'education' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'application_date' => 'sometimes|date',
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

    /**
     * Get candidates by position.
     *
     * @param string $position
     * @return array
     */
    public function getCandidatesByPosition(string $position): array
    {
        $candidates = $this->candidateRepository->getByPosition($position);

        return [
            'success' => true,
            'data' => $candidates
        ];
    }

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
