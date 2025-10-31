<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return handleApiException($e);
            }
        });

        function handleApiException(Throwable $e)
        {

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized. Silakan login terlebih dahulu.',
                    'data' => null,
                ], 401);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Endpoint atau sumber daya tidak ditemukan.',
                    'data' => null,
                ], 404);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Method tidak diizinkan.',
                    'data' => null,
                ], 405);
            }

            $message = app()->environment('production')
                ? 'Terjadi kesalahan server.'
                : $e->getMessage();

            return response()->json([
                'status' => false,
                'message' => $message,
                'data' => null,
            ], 500);
        }
    })->create();