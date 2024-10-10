<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        $middleware->trustHosts(at: ['slippy-surf-wtnb61jj78.ploi.site']);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call('migrate:fresh --seed --force')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
