<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(remove: [
            VerifyCsrfToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (UniqueConstraintViolationException $exception) {
            $data = ['message' => 'Resource already exists.'];

            if (app('env') !== 'production') {
                $data['bindings'] = $exception->getBindings();
            }

            return response()->json(data: $data, status: 500);
        });

        $exceptions->render(function (AccessDeniedHttpException $exception) {
            return response()->json(data: ['message' => $exception->getMessage()], status: 403);
        });

        $exceptions->render(function (NotFoundHttpException|ModelNotFoundException $_, $request) {
            if (! $request->header('accept') || ! Str::contains($request->header('accept'), 'application/json')) {

                return response()->view('errors.404');
            }

            return response()->json(data: ['message' => 'The resource that you are searching for doesn\'t exists.'], status: 404);
        });
    })->create();
