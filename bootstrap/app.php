<?php

use App\Http\Middleware\SetDeviceId;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            SetDeviceId::class,
        ]);
        $middleware->alias([
            'IsAdmin' => \App\Http\Middleware\IsAdmin::class,
            'IsSeller' => \App\Http\Middleware\IsSeller::class,
            'IsUser' => \App\Http\Middleware\IsUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
