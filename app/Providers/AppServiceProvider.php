<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Events\QueryExecuted;
use App\Models\Setting;
use App\Services\UserService;
use App\Services\ParticipantService;
use App\Services\CategoryService;
use App\Repositories\UserRepository;
use App\Repositories\ParticipantRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Services
        $this->app->singleton(UserRepository::class);
        $this->app->singleton(ParticipantRepository::class);
        
        $this->app->singleton(UserService::class, function ($app) {
            return new UserService($app->make(UserRepository::class));
        });

        $this->app->singleton(ParticipantService::class, function ($app) {
            return new ParticipantService($app->make(ParticipantRepository::class));
        });

        $this->app->singleton(CategoryService::class);

        // Enable query logging in development
        if ($this->app->environment('development')) {
            Event::listen(QueryExecuted::class, function ($query) {
                if ($query->time > 1000) { // Log queries slower than 1 second
                    \Illuminate\Support\Facades\Log::warning('Slow Query Detected', [
                        'query' => $query->sql,
                        'time' => $query->time . 'ms'
                    ]);
                }
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings with all views using a singleton pattern or simple cache
        View::composer('*', function ($view) {
            static $appSettings = null;

            if ($appSettings === null) {
                try {
                    $appSettings = Setting::all()->pluck('value', 'key');
                } catch (\Exception $e) {
                    $appSettings = collect();
                }
            }

            $view->with('appSettings', $appSettings);
        });

        // Share auth user with all views
        View::composer('*', function ($view) {
            $view->with('authUser', \Illuminate\Support\Facades\Auth::user());
        });
        
        // Add security headers macro
        Response::macro('withSecurityHeaders', function ($response) {
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
            return $response;
        });

        // Validate database connection
        $this->validateDatabaseConnection();
    }

    /**
     * Validate database connection on boot
     *
     * @return void
     */
    private function validateDatabaseConnection(): void
    {
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::critical('Database connection failed', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
