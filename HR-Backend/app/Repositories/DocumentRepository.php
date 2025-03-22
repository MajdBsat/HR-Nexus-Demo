<?php

namespace App\Repositories;

use App\Models\Document;
use App\Models\User;
use App\Repositories\Interfaces\DocumentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DocumentRepository implements DocumentRepositoryInterface
{
    /**
     * Get all documents
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Document::all();
    }

    /**
     * Get document by ID
     *
     * @param int $id
     * @return Document|null
     */
    public function findById(int $id): ?Document
    {
        return Document::find($id);
    }

    /**
     * Create a new document
     *
     * @param array $data
     * @return Document
     */
    public function create(array $data): Document
    {
        return Document::create($data);
    }

    /**
     * Update a document
     *
     * @param int $id
     * @param array $data
     * @return Document|null
     */
    public function update(int $id, array $data): ?Document
    {
        $document = $this->findById($id);

        if ($document) {
            $document->update($data);
            return $document;
        }

        return null;
    }

    /**
     * Delete a document
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $document = $this->findById($id);

        if ($document) {
            return $document->delete();
        }

        return false;
    }

    /**
     * Get documents by user ID
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection
    {
        return Document::where('user_id', $userId)->get();
    }

    /**
     * Get documents by category
     *
     * @param string $category
     * @return Collection
     */
    public function getByCategory(string $category): Collection
    {
        return Document::where('category', $category)->get();
    }

    /**
     * Get documents by document type
     *
     * @param string $documentType
     * @return Collection
     */
    public function getByDocumentType(string $documentType): Collection
    {
        return Document::where('document_type', $documentType)->get();
    }

    /**
     * Search documents by title or description
     *
     * @param string $searchTerm
     * @return Collection
     */
    public function search(string $searchTerm): Collection
    {
        return Document::where('title', 'like', "%{$searchTerm}%")
            ->orWhere('description', 'like', "%{$searchTerm}%")
            ->get();
    }

    /**
     * Check if user exists
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool
    {
        return User::where('id', $userId)->exists();
    }
}
