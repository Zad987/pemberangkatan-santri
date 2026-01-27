<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Base Repository for all models
 * 
 * Provides common CRUD operations with caching support for all models.
 * All repository classes should extend this base class to inherit 
 * standard database operations with optional caching.
 * 
 * @package App\Repositories
 * @author Your Name
 * @version 1.0.0
 */
abstract class BaseRepository
{
    protected Model $model;
    protected string $cachePrefix = '';
    protected int $cacheTime = 3600; // 1 hour default

    public function __construct()
    {
        $this->model = $this->getModel();
        $this->cachePrefix = 'repo_' . strtolower(class_basename($this->model)) . '_';
    }

    /**
     * Get the model class
     *
     * @return Model
     */
    abstract protected function getModel(): Model;

    /**
     * Set cache time in minutes
     *
     * @param int $minutes
     * @return $this
     */
    public function setCacheTime(int $minutes): self
    {
        $this->cacheTime = $minutes;
        return $this;
    }

    /**
     * Get all records with optional caching
     *
     * @param array $columns
     * @param bool $useCache
     * @return Collection
     */
    public function all(array $columns = ['*'], bool $useCache = true): Collection
    {
        if (!$useCache) {
            return $this->model->select($columns)->get();
        }

        $cacheKey = $this->cachePrefix . 'all:' . md5(serialize($columns));
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($columns) {
            return $this->model->select($columns)->get();
        });
    }

    /**
     * Get paginated records with optional caching
     *
     * @param int $perPage
     * @param array $columns
     * @param bool $useCache
     * @return mixed
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], bool $useCache = true)
    {
        if (!$useCache) {
            return $this->model->paginate($perPage, $columns);
        }

        $page = request()->get('page', 1);
        $cacheKey = $this->cachePrefix . "paginate:{$perPage}:" . md5(serialize($columns)) . ":page_{$page}";
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($perPage, $columns) {
            return $this->model->paginate($perPage, $columns);
        });
    }

    /**
     * Find record by ID with optional caching
     *
     * @param int $id
     * @param array $columns
     * @param bool $useCache
     * @return Model|null
     */
    public function find(int $id, array $columns = ['*'], bool $useCache = true): ?Model
    {
        if (!$useCache) {
            return $this->model->select($columns)->find($id);
        }

        $cacheKey = $this->cachePrefix . "find:{$id}:" . md5(serialize($columns));
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($id, $columns) {
            return $this->model->select($columns)->find($id);
        });
    }

    /**
     * Find record or fail with optional caching
     *
     * @param int $id
     * @param array $columns
     * @param bool $useCache
     * @return Model
     */
    public function findOrFail(int $id, array $columns = ['*'], bool $useCache = true): Model
    {
        if (!$useCache) {
            return $this->model->select($columns)->findOrFail($id);
        }

        $cacheKey = $this->cachePrefix . "findOrFail:{$id}:" . md5(serialize($columns));
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($id, $columns) {
            return $this->model->select($columns)->findOrFail($id);
        });
    }

    /**
     * Find by column with optional caching
     *
     * @param string $column
     * @param mixed $value
     * @param array $columns
     * @param bool $useCache
     * @return Model|null
     */
    public function findBy(string $column, $value, array $columns = ['*'], bool $useCache = true): ?Model
    {
        if (!$useCache) {
            return $this->model->select($columns)->where($column, $value)->first();
        }

        $cacheKey = $this->cachePrefix . "findBy:{$column}:{$value}:" . md5(serialize($columns));
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($column, $value, $columns) {
            return $this->model->select($columns)->where($column, $value)->first();
        });
    }

    /**
     * Find multiple by column with optional caching
     *
     * @param string $column
     * @param mixed $value
     * @param array $columns
     * @param bool $useCache
     * @return Collection
     */
    public function findAllBy(string $column, $value, array $columns = ['*'], bool $useCache = true): Collection
    {
        if (!$useCache) {
            return $this->model->select($columns)->where($column, $value)->get();
        }

        $cacheKey = $this->cachePrefix . "findAllBy:{$column}:{$value}:" . md5(serialize($columns));
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($column, $value, $columns) {
            return $this->model->select($columns)->where($column, $value)->get();
        });
    }

    /**
     * Create a new record
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $result = $this->model->create($data);
        $this->clearCache();
        return $result;
    }

    /**
     * Update a record
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $result = $this->find($id)?->update($data) ?? false;
        $this->clearCache();
        return $result;
    }

    /**
     * Delete a record
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $result = $this->find($id)?->delete() ?? false;
        $this->clearCache();
        return $result;
    }

    /**
     * Clear cached data for this repository
     *
     * @return void
     */
    protected function clearCache(): void
    {
        // Get all cache keys that match the prefix and flush them
        Cache::forget($this->cachePrefix . '*');
    }

    /**
     * Get count of records with optional caching
     *
     * @param bool $useCache
     * @return int
     */
    public function count(bool $useCache = true): int
    {
        if (!$useCache) {
            return $this->model->count();
        }

        $cacheKey = $this->cachePrefix . 'count';
        
        return Cache::remember($cacheKey, $this->cacheTime, function () {
            return $this->model->count();
        });
    }

    /**
     * Check if record exists with optional caching
     *
     * @param int $id
     * @param bool $useCache
     * @return bool
     */
    public function exists(int $id, bool $useCache = true): bool
    {
        if (!$useCache) {
            return $this->model->where('id', $id)->exists();
        }

        $cacheKey = $this->cachePrefix . "exists:{$id}";
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($id) {
            return $this->model->where('id', $id)->exists();
        });
    }

    /**
     * Get first record with optional caching
     *
     * @param array $columns
     * @param bool $useCache
     * @return Model|null
     */
    public function first(array $columns = ['*'], bool $useCache = true): ?Model
    {
        if (!$useCache) {
            return $this->model->select($columns)->first();
        }

        $cacheKey = $this->cachePrefix . 'first:' . md5(serialize($columns));
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($columns) {
            return $this->model->select($columns)->first();
        });
    }

    /**
     * Search with multiple conditions with optional caching
     *
     * @param array $conditions
     * @param array $columns
     * @param bool $useCache
     * @return Collection
     */
    public function search(array $conditions, array $columns = ['*'], bool $useCache = true): Collection
    {
        if (!$useCache) {
            $query = $this->model->select($columns);
            
            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }
            
            return $query->get();
        }

        $cacheKey = $this->cachePrefix . 'search:' . md5(serialize($conditions) . serialize($columns));
        
        return Cache::remember($cacheKey, $this->cacheTime, function () use ($conditions, $columns) {
            $query = $this->model->select($columns);
            
            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }
            
            return $query->get();
        });
    }
}
