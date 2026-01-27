<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        try {
            $category = Category::create($data);

            Log::info('Category created', [
                'category_id' => $category->id,
                'name' => $category->name,
                'created_by' => Auth::id(),
            ]);

            return $category;
        } catch (\Exception $e) {
            Log::error('Error creating category', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    /**
     * Update category
     *
     * @param int $categoryId
     * @param array $data
     * @return bool
     */
    public function updateCategory(int $categoryId, array $data): bool
    {
        try {
            $category = Category::findOrFail($categoryId);
            $updated = $category->update($data);

            if ($updated) {
                Log::info('Category updated', [
                    'category_id' => $categoryId,
                    'updated_by' => Auth::id(),
                ]);
            }

            return $updated;
        } catch (\Exception $e) {
            Log::error('Error updating category', [
                'category_id' => $categoryId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Delete category
     *
     * @param int $categoryId
     * @return bool
     */
    public function deleteCategory(int $categoryId): bool
    {
        try {
            $category = Category::findOrFail($categoryId);
            
            // Check if category has participants
            if ($category->participants()->count() > 0) {
                throw new \Exception('Kategori tidak dapat dihapus karena memiliki peserta terdaftar.');
            }

            $deleted = $category->delete();

            if ($deleted) {
                Log::info('Category deleted', [
                    'category_id' => $categoryId,
                    'deleted_by' => Auth::id(),
                ]);
            }

            return $deleted;
        } catch (\Exception $e) {
            Log::error('Error deleting category', [
                'category_id' => $categoryId,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Get category by ID
     *
     * @param int $categoryId
     * @return Category
     */
    public function getCategoryById(int $categoryId): Category
    {
        return Category::with('participants')->findOrFail($categoryId);
    }

    /**
     * Get all categories
     *
     * @return mixed
     */
    public function getAllCategories()
    {
        return Category::withCount('participants')->get();
    }

    /**
     * Get categories with participant count
     *
     * @return mixed
     */
    public function getCategoriesWithCount()
    {
        return Category::with(['participants' => function ($q) {
            $q->with('payments');
        }])
        ->withCount('participants')
        ->get();
    }
}
