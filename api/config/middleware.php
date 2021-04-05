<?php

declare(strict_types=1);

use App\Http\Middleware\ClearEmptyInputMiddleware;
use App\Http\Middleware\Catcher\DomainExceptionHandlerMiddleware;
use App\Http\Middleware\Catcher\TypeErrorMiddleware;
use App\Http\Middleware\Catcher\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $app): void {
    $app->add(ValidationExceptionMiddleware::class);
    $app->add(TypeErrorMiddleware::class);
    $app->add(DomainExceptionHandlerMiddleware::class);
    $app->add(ClearEmptyInputMiddleware::class);
    $app->addBodyParsingMiddleware();
    $app->add(ErrorMiddleware::class);
};
