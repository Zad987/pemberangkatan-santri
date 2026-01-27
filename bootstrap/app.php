<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'daerah' => \App\Http\Middleware\DaerahMiddleware::class,
            'check.session' => \App\Http\Middleware\CheckSession::class,
            'rate.limit' => \App\Http\Middleware\ApiRateLimiter::class,
        ]);

        // CheckSession is only applied explicitly where needed
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();