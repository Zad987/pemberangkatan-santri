<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Region;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display list of users
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        try {
            $users = $this->userService->getActiveUsers();
            $regions = Region::all();

            $this->logAction('VIEW', 'Melihat daftar user', 'User');

            return view('tambah-user', compact('users', 'regions'));
        } catch (\Exception $e) {
            $this->logAction('VIEW_FAILED', 'Gagal melihat daftar user: ' . $e->getMessage(), 'User');
            
            return $this->errorBackRedirect('Terjadi kesalahan saat memuat data user');
        }
    }

    /**
     * Store a newly created user
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());

            $this->logAction('CREATE', 'Membuat user baru: ' . $user->username, 'User', $user->id);

            return $this->successRedirect('tambah.user', 'User berhasil ditambahkan dengan username: ' . $user->username);
        } catch (\Exception $e) {
            $this->logAction('CREATE_FAILED', 'Gagal membuat user: ' . $e->getMessage(), 'User');

            return $this->errorBackRedirect('Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    /**
     * Display the user details
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            $regions = Region::all();

            // Authorization
            if (Auth::user()->role !== 'induk' && Auth::id() !== (int)$id) {
                abort(403, 'Unauthorized access to user details');
            }

            $this->logAction('VIEW', 'Melihat detail user: ' . $user->username, 'User', $user->id);

            return view('detail-user', compact('user', 'regions'));
        } catch (ModelNotFoundException $e) {
            $this->logAction('VIEW_FAILED', 'User tidak ditemukan: ' . $id, 'User');
            
            return $this->errorBackRedirect('User tidak ditemukan');
        } catch (\Exception $e) {
            $this->logAction('VIEW_FAILED', 'Gagal melihat detail user: ' . $e->getMessage(), 'User');
            
            return $this->errorBackRedirect('Terjadi kesalahan saat melihat detail user');
        }
    }

    /**
     * Update user information
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            // Authorization check
            if (!Auth::user()->isAdmin() && Auth::id() !== (int)$id) {
                abort(403, 'Unauthorized to update user');
            }
            
            $this->userService->updateUser($id, $request->validated());

            $this->logAction('UPDATE', 'Memperbarui user', 'User', $id);

            return $this->successRedirect('detail.user', 'User berhasil diperbarui', ['id' => $id]);
        } catch (ModelNotFoundException $e) {
            $this->logAction('UPDATE_FAILED', 'User tidak ditemukan untuk update: ' . $id, 'User', $id);
            
            return $this->errorBackRedirect('User tidak ditemukan');
        } catch (\Exception $e) {
            $this->logAction('UPDATE_FAILED', 'Gagal memperbarui user: ' . $e->getMessage(), 'User', $id);

            return $this->errorBackRedirect('Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    /**
     * Update user password
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UpdateUserRequest $request, $id)
    {
        try {
            // Authorization
            if (!Auth::user()->isAdmin() && Auth::id() !== (int)$id) {
                abort(403, 'Unauthorized to update password');
            }

            // Only update password field
            $passwordData = ['password' => $request->password];
            $this->userService->updateUser($id, $passwordData);

            $this->logAction('UPDATE', 'Mengubah password user', 'User', $id);

            return $this->successRedirect('detail.user', 'Password berhasil diubah', ['id' => $id]);
        } catch (ModelNotFoundException $e) {
            $this->logAction('UPDATE_FAILED', 'User tidak ditemukan untuk update password: ' . $id, 'User', $id);
            
            return $this->errorBackRedirect('User tidak ditemukan');
        } catch (\Exception $e) {
            $this->logAction('UPDATE_FAILED', 'Gagal mengubah password: ' . $e->getMessage(), 'User', $id);

            return $this->errorBackRedirect('Gagal mengubah password: ' . $e->getMessage());
        }
    }

    /**
     * Delete a user
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            // Authorization check
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized to delete user');
            }
            
            // Prevent self-deletion
            if (Auth::id() === (int)$id) {
                return $this->errorBackRedirect('Anda tidak dapat menghapus akun sendiri');
            }

            $this->userService->deleteUser($id);

            $this->logAction('DELETE', 'Menghapus user', 'User', $id);

            return $this->successRedirect('tambah.user', 'User berhasil dihapus');
        } catch (ModelNotFoundException $e) {
            $this->logAction('DELETE_FAILED', 'User tidak ditemukan untuk dihapus: ' . $id, 'User', $id);
            
            return $this->errorBackRedirect('User tidak ditemukan');
        } catch (\Exception $e) {
            $this->logAction('DELETE_FAILED', 'Gagal menghapus user: ' . $e->getMessage(), 'User', $id);

            return $this->errorBackRedirect('Gagal menghapus user: ' . $e->getMessage());
        }
    }

    /**
     * Logout a user device
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutDevice($id)
    {
        try {
            // Authorization
            if (Auth::user()->role !== 'induk' && Auth::id() !== (int)$id) {
                abort(403, 'Unauthorized to logout device');
            }

            $this->userService->updateUser($id, ['current_session_id' => null]);

            $this->logAction('UPDATE', 'Melepaskan perangkat user', 'User', $id);

            return $this->successRedirect('detail.user', 'Perangkat berhasil dilepaskan', ['id' => $id]);
        } catch (ModelNotFoundException $e) {
            $this->logAction('UPDATE_FAILED', 'User tidak ditemukan untuk logout device: ' . $id, 'User', $id);
            
            return $this->errorBackRedirect('User tidak ditemukan');
        } catch (\Exception $e) {
            return $this->errorBackRedirect('Gagal melepaskan perangkat: ' . $e->getMessage());
        }
    }
}
