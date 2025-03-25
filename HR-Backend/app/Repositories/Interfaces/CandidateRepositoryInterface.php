<?php

namespace App\Repositories\Interfaces;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Collection;

interface CandidateRepositoryInterface
{
    /**
     * Get all candidates
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get candidate by ID
     *
     * @param int $id
     * @return Candidate|null
     */
    public function findById(int $id): ?Candidate;

    /**
     * Create a new candidate
     *
     * @param array $data
     * @return Candidate
     */
    public function create(array $data): Candidate;

    /**
     * Update a candidate
     *
     * @param int $id
     * @param array $data
     * @return Candidate|null
     */
    public function update(int $id, array $data): ?Candidate;

    /**
     * Delete a candidate
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get candidates by position
     *
     * @param string $position
     * @return Collection
     */
    // public function getByPosition(string $position): Collection;

    /**
     * Get candidates by status
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection;

    /**
     * Search candidates by name or email
     *
     * @param string $searchTerm
     * @return Collection
     */
    public function search(string $searchTerm): Collection;
}
