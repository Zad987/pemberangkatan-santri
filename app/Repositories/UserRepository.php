<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    /**
     * Get the model class
     *
     * @return Model
     */
    protected function getModel(): Model
    {
        return new User();
    }

    /**
     * Get active users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActive()
    {
        return $this->model->where('is_active', true)->with('region')->get();
    }

    /**
     * Get users by role
     *
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByRole(string $role)
    {
        return $this->model->where('role', $role)->with('region')->get();
    }

    /**
     * Get admin users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAdmins()
    {
        return $this->getByRole('induk');
    }

    /**
     * Get daerah users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDaerah()
    {
        return $this->getByRole('daerah');
    }

    /**
     * Search users by name or username
     *
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchByNameOrUsername(string $term)
    {
        return $this->model
            ->where('name', 'LIKE', "%{$term}%")
            ->orWhere('username', 'LIKE', "%{$term}%")
            ->with('region')
            ->get();
    }

    /**
     * Get user with region
     *
     * @param int $id
     * @return User|null
     */
    public function findWithRegion(int $id)
    {
        return $this->model->with('region')->findOrFail($id);
    }
}
