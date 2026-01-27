<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display list of categories
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        $this->logAction('VIEW', 'Melihat daftar kategori', 'Category');

        return view('tambah-kategori', compact('categories'));
    }

    /**
     * Store a newly created category
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = $this->categoryService->createCategory($request->validated());

            $this->logAction('CREATE', 'Membuat kategori baru: ' . $category->name, 'Category', $category->id);

            return $this->successRedirect('tambah.kategori', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            $this->logAction('CREATE_FAILED', 'Gagal membuat kategori: ' . $e->getMessage(), 'Category');

            return $this->errorBackRedirect('Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Display category details
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);

            $this->logAction('VIEW', 'Melihat detail kategori: ' . $category->name, 'Category', $category->id);

            return view('detail-kategori', compact('category'));
        } catch (\Exception $e) {
            return $this->errorBackRedirect('Kategori tidak ditemukan');
        }
    }

    /**
     * Update category
     *
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $this->categoryService->updateCategory($id, $request->validated());

            $this->logAction('UPDATE', 'Memperbarui kategori', 'Category', $id);

            return $this->successRedirect('detail.kategori', 'Kategori berhasil diperbarui', ['id' => $id]);
        } catch (\Exception $e) {
            $this->logAction('UPDATE_FAILED', 'Gagal memperbarui kategori: ' . $e->getMessage(), 'Category', $id);

            return $this->errorBackRedirect('Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Delete a category
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);

            $this->logAction('DELETE', 'Menghapus kategori', 'Category', $id);

            return $this->successRedirect('tambah.kategori', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            $this->logAction('DELETE_FAILED', 'Gagal menghapus kategori: ' . $e->getMessage(), 'Category', $id);

            return $this->errorBackRedirect($e->getMessage());
        }
    }
}
