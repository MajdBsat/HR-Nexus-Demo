<?php

namespace App\Repositories\Interfaces;

use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;

interface DocumentRepositoryInterface
{
    /**
     * Get all documents
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get document by ID
     *
     * @param int $id
     * @return Document|null
     */
    public function findById(int $id): ?Document;

    /**
     * Create a new document
     *
     * @param array $data
     * @return Document
     */
    public function create(array $data): Document;

    /**
     * Update a document
     *
     * @param int $id
     * @param array $data
     * @return Document|null
     */
    public function update(int $id, array $data): ?Document;

    /**
     * Delete a document
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get documents by user ID
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUserId(int $userId): Collection;

    /**
     * Get documents by category
     *
     * @param string $category
     * @return Collection
     */
    public function getByCategory(string $category): Collection;

    /**
     * Get documents by document type
     *
     * @param string $documentType
     * @return Collection
     */
    public function getByDocumentType(string $documentType): Collection;

    /**
     * Search documents by title or description
     *
     * @param string $searchTerm
     * @return Collection
     */
    public function search(string $searchTerm): Collection;

    /**
     * Check if user exists
     *
     * @param int $userId
     * @return bool
     */
    public function userExists(int $userId): bool;
}
