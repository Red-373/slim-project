<?php

declare(strict_types=1);

namespace App\Http\Middleware\Catcher;

use App\Infrastructure\Exception\TypeErrorException;
use App\Http\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TypeErrorMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (TypeErrorException $e) {
            return new JsonResponse([
                'errors' => $e->getMessage()
            ], 422);
        }
    }
}
