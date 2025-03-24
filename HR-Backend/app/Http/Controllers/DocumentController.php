<?php

namespace App\Http\Controllers;

use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DocumentController extends Controller
{
    /**
     * The document service instance.
     *
     * @var DocumentService
     */
    protected $documentService;

    /**
     * Create a new controller instance.
     *
     * @param DocumentService $documentService
     * @return void
     */
    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Display a listing of all documents
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $documents = $this->documentService->getAllDocuments();
        return response()->json(['data' => $documents], 200);
    }

    /**
     * Store a newly created document
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->documentService->createDocument($request->all());

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
     * Display the specified document
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $document = $this->documentService->getDocumentById($id);

        if (!$document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        return response()->json(['data' => $document], 200);
    }

    /**
     * Update the specified document
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $result = $this->documentService->updateDocument($id, $request->all());

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
     * Remove the specified document
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->documentService->deleteDocument($id);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['message' => $result['message']], 200);
    }

    /**
     * Get documents by user ID
     *
     * @param int $userId
     * @return JsonResponse
     */
    public function getByUserId(int $userId): JsonResponse
    {
        $result = $this->documentService->getDocumentsByUserId($userId);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 404);
        }

        return response()->json(['data' => $result['data']], 200);
    }

    /**
     * Get documents by category
     *
     * @param string $category
     * @return JsonResponse
     */
    public function getByCategory(string $category): JsonResponse
    {
        $result = $this->documentService->getDocumentsByCategory($category);
        return response()->json(['data' => $result['data']], 200);
    }

    /**
     * Get documents by document type
     *
     * @param string $documentType
     * @return JsonResponse
     */
    public function getByType(string $documentType): JsonResponse
    {
        $result = $this->documentService->getDocumentsByType($documentType);
        return response()->json(['data' => $result['data']], 200);
    }

    /**
     * Search documents by title or description
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $searchTerm = $request->input('search');
        $result = $this->documentService->searchDocuments($searchTerm);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 422);
        }

        return response()->json(['data' => $result['data']], 200);
    }
}
