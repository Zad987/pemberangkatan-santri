<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Service class for handling user-related business logic
 * 
 * This service handles all user operations including creation, updating, 
 * deletion, authentication, and status management.
 * 
 * @package App\Services
 * @author Your Name
 * @version 1.0.0
 */
class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function createUser(array $data): User
    {
        try {
            // Generate unique username
            $baseUsername = strtolower(str_replace(' ', '', $data['name']));
            $username = $baseUsername;
            $counter = 1;

            // Check if username already exists and generate unique one
            while ($this->userRepository->findBy('username', $username)) {
                $username = $baseUsername . $counter;
                $counter++;
            }

            $data['username'] = $username;
            $data['password'] = Hash::make($data['password']);

            $user = $this->userRepository->create($data);

            Log::info('User created', [
                'user_id' => $user->id ?? 0,
                'username' => $user->username,
                'created_by' => auth()->id() ?? 0,
            ]);

            return $user;
        } catch (\Exception $e) {
            Log::error('Error creating user', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    /**
     * Update user
     *
     * @param int $userId
     * @param array $data
     * @return bool
     * @throws ModelNotFoundException
     */
    public function updateUser(int $userId, array $data): bool
    {
        try {
            // Check if user exists first
            $user = $this->userRepository->find($userId);
            if (!$user) {
                throw new ModelNotFoundException("User with ID {$userId} not found");
            }

            // Remove password from update if not provided
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']); // Remove password field if not provided
            }

            $updated = $this->userRepository->update($userId, $data);

            if ($updated) {
                Log::info('User updated', [
                    'user_id' => $userId,
                    'updated_by' => auth()->id() ?? 0,
                ]);
            }

            return $updated;
        } catch (ModelNotFoundException $e) {
            Log::error('User not found during update', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating user', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Delete user
     *
     * @param int $userId
     * @return bool
     * @throws ModelNotFoundException
     */
    public function deleteUser(int $userId): bool
    {
        try {
            // Check if user exists first
            $user = $this->userRepository->find($userId);
            if (!$user) {
                throw new ModelNotFoundException("User with ID {$userId} not found");
            }

            // Prevent deletion of current user
            if (auth()->id() === $userId) {
                throw new \Exception('Cannot delete own account');
            }

            $deleted = $this->userRepository->delete($userId);

            if ($deleted) {
                Log::info('User deleted', [
                    'user_id' => $userId,
                    'deleted_by' => auth()->id() ?? 0,
                ]);
            }

            return $deleted;
        } catch (ModelNotFoundException $e) {
            Log::error('User not found during deletion', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error deleting user', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Get user by ID with relationships
     *
     * @param int $userId
     * @return User
     * @throws ModelNotFoundException
     */
    public function getUserById(int $userId): User
    {
        $user = $this->userRepository->findWithRegion($userId);
        if (!$user) {
            throw new ModelNotFoundException("User with ID {$userId} not found");
        }
        return $user;
    }

    /**
     * Get all active users
     *
     * @return mixed
     */
    public function getActiveUsers()
    {
        return $this->userRepository->getActive();
    }

    /**
     * Get users by role
     *
     * @param string $role
     * @return mixed
     */
    public function getUsersByRole(string $role)
    {
        return $this->userRepository->getByRole($role);
    }

    /**
     * Search users
     *
     * @param string $term
     * @return mixed
     */
    public function searchUsers(string $term)
    {
        return $this->userRepository->searchByNameOrUsername($term);
    }

    /**
     * Verify user credentials
     *
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function verifyCredentials(string $username, string $password): ?User
    {
        $user = $this->userRepository->findBy('username', $username);

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return null;
    }

    /**
     * Activate user account
     *
     * @param int $userId
     * @return bool
     */
    public function activateUser(int $userId): bool
    {
        try {
            $user = $this->userRepository->find($userId);
            if (!$user) {
                throw new ModelNotFoundException("User with ID {$userId} not found");
            }

            return $this->userRepository->update($userId, ['is_active' => true]);
        } catch (\Exception $e) {
            Log::error('Error activating user', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Deactivate user account
     *
     * @param int $userId
     * @return bool
     */
    public function deactivateUser(int $userId): bool
    {
        try {
            $user = $this->userRepository->find($userId);
            if (!$user) {
                throw new ModelNotFoundException("User with ID {$userId} not found");
            }

            // Prevent deactivation of current user
            if (auth()->id() === $userId) {
                throw new \Exception('Cannot deactivate own account');
            }

            return $this->userRepository->update($userId, ['is_active' => false]);
        } catch (\Exception $e) {
            Log::error('Error deactivating user', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
