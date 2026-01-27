<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class AuthController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show the login form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle login request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8'
            ],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.max' => 'Username maksimal 255 karakter.',
            'username.regex' => 'Username tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        try {
            // Verify credentials
            $user = $this->userService->verifyCredentials($request->username, $request->password);

            if (!$user) {
                $this->logAction('LOGIN_FAILED', 'Percobaan login gagal: Username atau password salah', 'User');
                
                return redirect()->back()
                    ->withInput($request->only('username'))
                    ->withErrors([
                        'username' => 'Username atau password salah.',
                    ]);
            }

            // Check if user is active
            if (!$user->is_active) {
                $this->logAction('LOGIN_FAILED', 'Akun user tidak aktif: ' . $user->username, 'User');
                
                return redirect()->back()
                    ->withInput($request->only('username'))
                    ->withErrors([
                        'username' => 'Akun Anda belum diaktifkan. Hubungi administrator.',
                    ]);
            }

            // Login the user
            Auth::login($user, $request->filled('remember'));

            // Update user login info
            $user->update([
                'current_session_id' => session()->getId(),
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            $this->logAction('LOGIN', 'Login berhasil: ' . $user->username, 'User', $user->id);

            // Redirect based on user role
            if ($user->isAdmin()) {
                return redirect()->intended(route('dashboard.admin'))
                    ->with('success', 'Selamat datang kembali, Admin!');
            } elseif ($user->isDaerah()) {
                return redirect()->intended(route('dashboard.daerah'))
                    ->with('success', 'Selamat datang kembali!');
            } else {
                return redirect()->intended(route('dashboard.pengunjung'))
                    ->with('success', 'Selamat datang sebagai pengunjung!');
            }
        } catch (\Exception $e) {
            $this->logAction('LOGIN_ERROR', 'Error pada login: ' . $e->getMessage(), 'User');

            return redirect()->back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'Terjadi kesalahan saat login. Silakan coba lagi.',
                ]);
        }
    }

    /**
     * Handle logout
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $user = Auth::user();
        
        if ($user) {
            $this->logAction('LOGOUT', 'User logout: ' . $user->username, 'User', $user->id);
        }

        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout');
    }

    /**
     * Become a visitor
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function becomeVisitor()
    {
        // Create a temporary guest session
        session(['guest_access' => true]);
        
        return redirect()->route('dashboard.pengunjung')
            ->with('info', 'Anda sedang mengakses sebagai pengunjung');
    }
}
