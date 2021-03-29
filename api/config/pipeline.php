<?php
declare(strict_types=1);

use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Middleware\CredentialsMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\RouteMiddleware;

/** @var \Framework\Http\Application $app */

$app->pipe(ErrorHandlerMiddleware::class);
//$app->pipe(ResponseLoggerMiddleware::class);
$app->pipe(ProfilerMiddleware::class);
$app->pipe('cabinet', BasicAuthMiddleware::class);
$app->pipe(CredentialsMiddleware::class);
$app->pipe(RouteMiddleware::class);
$app->pipe(DispatchMiddleware::class);