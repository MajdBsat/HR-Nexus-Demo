<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Services\CandidateService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use PhpParser\ErrorHandler\Collecting;

class CandidateController extends Controller
{
    /**
     * The candidate service instance.
     *
     * @var CandidateService
     */
    protected $candidateService;

    /**
     * Create a new controller instance.
     *
     * @param CandidateService $candidateService
     * @return void
     */
    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    /**
     * Display a listing of all candidates
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $candidates = $this->candidateService->getAllCandidates();
        return response()->json(['data' => $candidates], 200);
    }

    /**
     * Store a newly created candidate
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->candidateService->createCandidate($request->all());

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message'],
                'errors' => $result['errors'] ?? null
            ], 422);
        }

        return response()->json([
            'message' => $result['message'],
            'data' => $result['data']
        ], 201);
    }

    /**
     * Display the specified candidate
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $candidate = $this->candidateService->getCandidateById($id);

        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }

        return response()->json(['data' => $candidate], 200);
    }

    /**
     * Update the specified candidate
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->candidateService->updateCandidate($id, $request->all());

        if (!$result['success']) {
            $statusCode = isset($result['errors']) ? 422 : 404;
            return response()->json([
                'message' => $result['message'],
                'errors' => $result['errors'] ?? null
            ], $statusCode);
        }

        return response()->json([
            'message' => $result['message'],
            'data' => $result['data']
        ], 200);
    }

    /**
     * Remove the specified candidate
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->candidateService->deleteCandidate($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['message' => $result['message']], 200);
    }

    /**
     * Get candidates by position
     *
     * @param string $position
     * @return JsonResponse
     */
    // public function getByPosition(string $position): JsonResponse
    // {
    //     $result = $this->candidateService->getCandidatesByPosition($position);
    //     return response()->json(['data' => $result['data']], 200);
    // }

    /**
     * Get candidates by status
     *
     * @param string $status
     * @return JsonResponse
     */
    public function getByStatus(string $status): JsonResponse
    {
        $result = $this->candidateService->getCandidatesByStatus($status);

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message'],
                'errors' => $result['errors'] ?? null
            ], 422);
        }

        return response()->json(['data' => $result['data']], 200);
    }

    public function nextStep(int $id){
        return $this->candidateService->updateCandidateStatus($id);
    }

    public function reject(int $id){
        return $this->candidateService->updateCandidateReject($id);
    }
    /**
     * Search candidates by name or email
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search($searchTerm): Collection
    {
        return Candidate::where('email', 'like', "%{$searchTerm}%")
            ->orWhere('name', 'like', "%{$searchTerm}%")
            ->get();
    }
}
