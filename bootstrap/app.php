<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api-rtub',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api-rtub/*') || $request->expectsJson(),
        );
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {
         if($request->expectsJson() || $request->is('api-rtub/*')) {
             return response()->json([
                 "message" => "Validation error",
                 "code" => 422,
                 "errors" => $e->errors()
             ], 422);
         }
        });
        $exceptions->render(function(NotFoundHttpException $e, Request $request) {
            if($request->expectsJson() || $request->is('api-rtub/*')) {
                return response()->json([
                    "message" => "Not Found",
                    "code" => 404,
                ], 404);
            }
        });
        $exceptions->render(function(\Symfony\Component\HttpKernel\Exception\HttpException $e, Request $request) {
            if(($request->expectsJson() || $request->is('api-rtub/*')) && $e->getStatusCode() === 403) {
                return response()->json([
                    "message" => "GET OUT!!!",
                    "code" => 403,
                ], 403);
            }
        });
    })->create();
