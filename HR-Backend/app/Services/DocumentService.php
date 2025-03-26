<?php

namespace App\Services;

use App\Models\Document;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    /**
     * The document repository instance.
     *
     * @var DocumentRepositoryInterface
     */
    protected $documentRepository;

    /**
     * Create a new service instance.
     *
     * @param DocumentRepositoryInterface $documentRepository
     * @return void
     */
    public function __construct(DocumentRepositoryInterface $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    /**
     * Get all documents.
     *
     * @return Collection
     */
    public function getAllDocuments(): Collection
    {
        return $this->documentRepository->getAll();
    }

    /**
     * Get document by ID.
     *
     * @param int $id
     * @return Document|null
     */
    public function getDocumentById(int $id): ?Document
    {
        return $this->documentRepository->findById($id);
    }

    /**
     * Create a new document.
     *
     * @param array $data
     * @return array
     */
    public function createDocument($request,$user_id): array
    {
        $data = $request->all();

    // Validation
    $validator = Validator::make($data, [
        'file' => 'required|file|max:2048', // Max 2MB
        'type' => 'required|string',
    ]);

    if ($validator->fails()) {
        return [
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ];
    }

    $file = $request->file('file');
    $type = $request->input('type');

    // Convert to Base64
    $fileContents = base64_encode(file_get_contents($file->getRealPath()));

    // Define storage path
    $fileName = time() . '.' . $file->getClientOriginalExtension();
    $filePath = 'uploads/' . $fileName;

    // Save file in storage
    Storage::disk('public')->put($filePath, base64_decode($fileContents));

    // Save to DB
    $document = Document::create([
        'type' => $type,
        'file_path' => $filePath,
        'user_id' => $user_id
    ]);

  
        return [
            'success' => true,
            'message' => 'File uploaded successfully',
            'data' => [
            'id' => $document->id,
            'fileUrl' => asset('storage/' . $filePath),
        ]
    ];
    }

    /**
     * Update a document.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateDocument(int $id, array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'sometimes|integer|exists:users,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'sometimes|string|max:255',
            'file_type' => 'sometimes|string|max:50',
            'file_size' => 'sometimes|integer',
            'document_type' => 'sometimes|string|max:100',
            'category' => 'sometimes|string|max:100',
            'version' => 'nullable|string|max:50',
            'status' => 'sometimes|in:draft,active,archived,deleted',
            'upload_date' => 'sometimes|date',
            'expiry_date' => 'nullable|date|after_or_equal:upload_date',
            'tags' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ];
        }

        $document = $this->documentRepository->update($id, $data);

        if (!$document) {
            return [
                'success' => false,
                'message' => 'Document not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Document updated successfully',
            'data' => $document
        ];
    }

    /**
     * Delete a document.
     *
     * @param int $id
     * @return array
     */
    public function deleteDocument(int $id): array
    {
        $result = $this->documentRepository->delete($id);

        if (!$result) {
            return [
                'success' => false,
                'message' => 'Document not found'
            ];
        }

        return [
            'success' => true,
            'message' => 'Document deleted successfully'
        ];
    }

    /**
     * Get documents by user ID.
     *
     * @param int $userId
     * @return array
     */
    public function getDocumentsByUserId(int $userId): array
    {
        if (!$this->documentRepository->userExists($userId)) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $documents = $this->documentRepository->getByUserId($userId);

        return [
            'success' => true,
            'data' => $documents
        ];
    }

    /**
     * Get documents by category.
     *
     * @param string $category
     * @return array
     */
    public function getDocumentsByCategory(string $category): array
    {
        $documents = $this->documentRepository->getByCategory($category);

        return [
            'success' => true,
            'data' => $documents
        ];
    }

    /**
     * Get documents by document type.
     *
     * @param string $documentType
     * @return array
     */
    public function getDocumentsByType(string $documentType): array
    {
        $documents = $this->documentRepository->getByDocumentType($documentType);

        return [
            'success' => true,
            'data' => $documents
        ];
    }

    /**
     * Search documents by title or description.
     *
     * @param string $searchTerm
     * @return array
     */
    public function searchDocuments(string $searchTerm): array
    {
        if (empty($searchTerm) || strlen($searchTerm) < 2) {
            return [
                'success' => false,
                'message' => 'Search term must be at least 2 characters long'
            ];
        }

        $documents = $this->documentRepository->search($searchTerm);

        return [
            'success' => true,
            'data' => $documents
        ];
    }
}
