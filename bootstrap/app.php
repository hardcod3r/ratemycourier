<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                    'errors' => ['exception' => 'User is not authenticated.'],
                    'timestamp' => now()->toISOString(),
                ], 401);
            }

            // **Validation Errors Handling (422)**
            if ($e instanceof ValidationException) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                    'timestamp' => now()->toISOString(),
                ], 422);
            }

            // **404 Not Found Handling**
            if ($e instanceof NotFoundHttpException) {
                #\Log::error('Not Found Exception:', ['url' => $request->url(), 'exception' => $e]);
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Resource Not Found',
                    'errors' => [],
                    'timestamp' => now()->toISOString(),
                ], 404);
            }

            // **405 Method Not Allowed**
            if ($e instanceof MethodNotAllowedHttpException) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Method Not Allowed',
                    'errors' => [],
                    'timestamp' => now()->toISOString(),
                ], 405);
            }

            // **500 Internal Server Error Handling**
            return new JsonResponse([
                'success' => false,
                'message' => 'Internal Server Error',
                'errors' => ['exception' => $e->getMessage()],
                'timestamp' => now()->toISOString(),
            ], 500);
        });
    })

    ->create();
