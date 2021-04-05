<?php

declare(strict_types=1);

namespace App\Http\Middleware\Catcher;

use App\Http\JsonResponse;
use DomainException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class DomainExceptionHandlerMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (DomainException $e) {
            $this->logger->warning($e->getMessage(), [
                'exception' => $e,
                'url' => (string)$request->getUri(),
            ]);
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 409);
        }
    }
}
