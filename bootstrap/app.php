<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /*
        // Group middleware
        // appending multiple middlewares to a single variable/alias
        $middleware->appendToGroup('ok-user', [
            ValidUser::class,
            ValidAge::class
        ]);

        // global middleware for single middleware
        $middleware->append(ValidUser::class);

        // global middleware for multiple middlewares
        $middleware->use([
            ValidUser::class,
            ValidAge::class
        ]);
        */
        $middleware->alias(['jwt' => App\Http\Middleware\JWTMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->hasHeader('api/*')) {
                return response()->json([
                    'message' => $e->getMessage()
                ]);
            }
        });
        //
    })->create();



// demo middlewares
class ValidUser
{
}

class ValidAge
{
}
