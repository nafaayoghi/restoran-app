<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Arahkan storage ke /tmp jika berjalan di Vercel / serverless
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || env('APP_ENV') === 'production') {
    $app->useStoragePath('/tmp/storage');
}

return $app;