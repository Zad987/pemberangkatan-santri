<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log all exceptions with context
            $user = auth()->user();
            $userId = $user ? $user->getAuthIdentifier() : 'guest';
            
            Log::error('Application Exception', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $userId,
                'ip_address' => request()->ip(),
                'url' => request()->fullUrl(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        // Handle authentication exceptions
        $this->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(ApiResponse::unauthorized('You need to login to access this resource.'));
            }

            return redirect()->guest(route('login'));
        });

        // Handle validation exceptions
        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(
                    ApiResponse::validationError($e->errors(), 'The given data was invalid.')
                );
            }

            return redirect()->back()
                ->withInput($request->input())
                ->withErrors($e->errors());
        });

        // Handle 404 errors
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(ApiResponse::notFound('The requested resource was not found.'));
            }

            return response()->view('errors.404', [], 404);
        });

        // Handle 405 errors
        $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(
                    ApiResponse::error('Method Not Allowed', 'The HTTP method is not allowed for this endpoint.', 405)
                );
            }

            return redirect()->back()->with('error', 'Method not allowed.');
        });

        // Handle rate limiting
        $this->renderable(function (TooManyRequestsHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Too Many Requests',
                    'message' => 'You have exceeded the rate limit. Please try again later.',
                    'retry_after' => $e->getHeaders()['Retry-After'] ?? 60
                ], 429);
            }

            return redirect()->back()
                ->with('error', 'Too many requests. Please try again in ' . ($e->getHeaders()['Retry-After'] ?? 60) . ' seconds.');
        });

        // Handle general exceptions
        $this->renderable(function (Throwable $e, Request $request) {
            // Don't report certain exceptions
            if ($this->shouldntReport($e)) {
                return null;
            }

            if ($request->expectsJson()) {
                return response()->json(
                    ApiResponse::error(
                        'Internal Server Error',
                        app()->environment('local') 
                            ? $e->getMessage() 
                            : 'An unexpected error occurred. Please try again later.',
                        500
                    )
                );
            }

            // For admin users, show detailed error in local environment
            $user = auth()->user();
            if (app()->environment('local') && $user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
                return response()->view('errors.debug', [
                    'exception' => $e
                ], 500);
            }

            return response()->view('errors.500', [], 500);
        });
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
                    ? response()->json(['error' => 'Unauthenticated.'], 401)
                    : redirect()->guest(route('login'));
    }
}