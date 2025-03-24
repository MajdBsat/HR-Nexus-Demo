<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /**
     * The user repository instance.
     *
     * @var UserRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param UserRepositoryInterface $repository
     * @return void
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all users.
     *
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return $this->repository->getAll();
    }

    /**
     * Get user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return $this->repository->findById($id);
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User|null
     */
    public function createUser(array $data): ?User
    {
        // Check if user with email already exists
        if ($this->repository->findByEmail($data['email'])) {
            return null;
        }

        return $this->repository->create($data);
    }

    /**
     * Update a user.
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function updateUser(int $id, array $data): ?User
    {
        // If email is being updated, check it doesn't conflict with another user
        if (isset($data['email'])) {
            $existingUser = $this->repository->findByEmail($data['email']);
            if ($existingUser && $existingUser->id !== $id) {
                return null;
            }
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Delete a user.
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
