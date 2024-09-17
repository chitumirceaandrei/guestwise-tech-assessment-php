<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Console\Commands\PopulateInteractionsStatistics;
use App\Console\Commands\PopulateImpressionsStatistics;
use App\Console\Commands\PopulateConversionsStatistics;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

    })
    ->withCommands([
        PopulateInteractionsStatistics::class,
        PopulateImpressionsStatistics::class,
        PopulateConversionsStatistics::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
