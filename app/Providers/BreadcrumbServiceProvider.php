<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class BreadcrumbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $breadcrumbs = $this->generateBreadcrumbs(request());
            $view->with('breadcrumbs', $breadcrumbs);
        });
    }

    /**
     * Generate breadcrumbs based on current route
     */
    protected function generateBreadcrumbs(Request $request)
    {
        $route = $request->route();
        if (!$route) return [];

        $breadcrumbs = [
            [
                'title' => 'Dashboard',
                'url' => $this->getDashboardUrl(),
                'icon' => '🏠'
            ]
        ];

        $routeName = $route->getName();
        
        switch ($routeName) {
            case 'dashboard.admin':
            case 'dashboard.daerah':
            case 'dashboard.pengunjung':
                // Dashboard is already the first item
                $breadcrumbs[0]['url'] = null; // Make it active
                break;

            case 'keseluruhan.peserta':
                $breadcrumbs[] = [
                    'title' => 'Data Peserta',
                    'url' => null,
                    'icon' => '👥'
                ];
                break;

            case 'detail.peserta':
                $breadcrumbs[] = [
                    'title' => 'Data Peserta',
                    'url' => route('keseluruhan.peserta'),
                    'icon' => '👥'
                ];
                $breadcrumbs[] = [
                    'title' => 'Detail Peserta',
                    'url' => null,
                    'icon' => '👤'
                ];
                break;

            case 'peserta.edit':
                $breadcrumbs[] = [
                    'title' => 'Data Peserta',
                    'url' => route('keseluruhan.peserta'),
                    'icon' => '👥'
                ];
                $breadcrumbs[] = [
                    'title' => 'Edit Peserta',
                    'url' => null,
                    'icon' => '✏️'
                ];
                break;

            case 'tambah.user':
                $breadcrumbs[] = [
                    'title' => 'Kelola User',
                    'url' => null,
                    'icon' => '👤'
                ];
                break;

            case 'detail.user':
                $breadcrumbs[] = [
                    'title' => 'Kelola User',
                    'url' => route('tambah.user'),
                    'icon' => '👤'
                ];
                $breadcrumbs[] = [
                    'title' => 'Detail User',
                    'url' => null,
                    'icon' => '👤'
                ];
                break;

            case 'tambah.daerah':
                $breadcrumbs[] = [
                    'title' => 'Kelola Daerah',
                    'url' => null,
                    'icon' => '🌍'
                ];
                break;

            case 'detail.daerah':
                $breadcrumbs[] = [
                    'title' => 'Kelola Daerah',
                    'url' => route('tambah.daerah'),
                    'icon' => '🌍'
                ];
                $breadcrumbs[] = [
                    'title' => 'Detail Daerah',
                    'url' => null,
                    'icon' => '🌍'
                ];
                break;

            case 'tambah.kategori':
                $breadcrumbs[] = [
                    'title' => 'Kelola Kategori',
                    'url' => null,
                    'icon' => '🏷️'
                ];
                break;

            case 'detail.kategori':
                $breadcrumbs[] = [
                    'title' => 'Kelola Kategori',
                    'url' => route('tambah.kategori'),
                    'icon' => '🏷️'
                ];
                $breadcrumbs[] = [
                    'title' => 'Detail Kategori',
                    'url' => null,
                    'icon' => '🏷️'
                ];
                break;

            case 'pengaturan':
                $breadcrumbs[] = [
                    'title' => 'Pengaturan',
                    'url' => null,
                    'icon' => '⚙️'
                ];
                break;

            default:
                // For unknown routes, try to infer from URL structure
                $pathParts = explode('/', trim($request->path(), '/'));
                if (count($pathParts) > 1) {
                    $breadcrumbs[] = [
                        'title' => ucfirst(str_replace('-', ' ', $pathParts[0])),
                        'url' => null,
                        'icon' => '📋'
                    ];
                }
                break;
        }

        return $breadcrumbs;
    }

    /**
     * Get appropriate dashboard URL based on user role
     */
    protected function getDashboardUrl()
    {
        $user = auth()->user();
        if (!$user) {
            return route('login');
        }
        
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return route('dashboard.admin');
        } elseif (method_exists($user, 'isDaerah') && $user->isDaerah()) {
            return route('dashboard.daerah');
        } else {
            return route('dashboard.pengunjung');
        }
    }
}