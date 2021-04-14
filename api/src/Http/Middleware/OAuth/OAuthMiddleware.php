<?php

declare(strict_types=1);

namespace App\Http\Middleware\OAuth;

use Exception;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class OAuthMiddleware implements MiddlewareInterface
{
    private ResourceServer $server;
    private ResponseInterface $response;

    public function __construct(ResourceServer $server)
    {
        $this->server = $server;
        $this->response = new Response();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $request = $this->server->validateAuthenticatedRequest($request);
        } catch (OAuthServerException $exception) {
            return $exception->generateHttpResponse($this->response);
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return (new OAuthServerException($exception->getMessage(), 0, 'unknown_error', 500))
                ->generateHttpResponse($this->response);
            // @codeCoverageIgnoreEnd
        }

        // Pass the request and response on to the next responder in the chain
        return $handler->handle($request);
    }
}
