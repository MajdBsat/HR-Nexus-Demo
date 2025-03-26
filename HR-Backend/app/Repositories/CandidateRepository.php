<?php

namespace App\Repositories;

use App\Models\Candidate;
use App\Repositories\Interfaces\CandidateRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CandidateRepository implements CandidateRepositoryInterface
{
    /**
     * Get all candidates
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Candidate::all();
    }

    /**
     * Get candidate by ID
     *
     * @param int $id
     * @return Candidate|null
     */
    public function findById(int $id): ?Candidate
    {
        return Candidate::find($id);
    }

    public function getCandidatebyUserID($user_id){
        return Candidate::where( "user_id",$user_id)->get();
    }
    public function findByUserIDandJobID(int $user_id, int $job_id): ?Candidate
    {
        return Candidate::where( "user_id",$user_id)
        ->where("job_id",$job_id)->first();
    }

    /**
     * Create a new candidate
     *
     * @param array $data
     * @return Candidate
     */
    public function create(array $data)
    {
        if($this->findByUserIDandJobID($data['user_id'],$data['job_id'])){
            return false;
        }
        return Candidate::create($data);
    }

    /**
     * Update a candidate
     *
     * @param int $id
     * @param array $data
     * @return Candidate|null
     */
    public function update(int $id, array $data): ?Candidate
    {
        $candidate = $this->findById($id)->with('user')->first();

        if ($candidate) {
            $candidate->update($data);
            return $candidate;
        }

        return null;
    }

    /**
     * Delete a candidate
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $candidate = $this->findById($id);

        if ($candidate) {
            return $candidate->delete();
        }

        return false;
    }

    /**
     * Get candidates by position
     *
     * @param string $position
     * @return Collection
     */
    // public function getByPosition(string $position): Collection
    // {
    //     return Candidate::where('position', $position)->get();
    // }

    /**
     * Get candidates by status
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        return Candidate::where('status', $status)->get();
    }

    /**
     * Search candidates by name or email
     *
     * @param string $searchTerm
     * @return Collection
     */
    public function search(string $searchTerm): Collection
    {
        return Candidate::where('name', 'like', "%{$searchTerm}%")
            ->orWhere('email', 'like', "%{$searchTerm}%")
            ->get();
    }
}
