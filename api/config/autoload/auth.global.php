<?php
declare(strict_types=1);

use App\Http\Middleware\BasicAuthMiddleware;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => Infrastructure\App\Http\Middleware\BasicAuthMiddlewareFactory::class,
        ],
    ],
    'auth' => [
        'users' => []
    ],
];