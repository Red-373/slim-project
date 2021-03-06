<?php

declare(strict_types=1);

namespace App\Http\Action;

use Exception;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class OAuthAction implements RequestHandlerInterface
{
    private AuthorizationServer $server;
    private LoggerInterface $logger;

    public function __construct(AuthorizationServer $server, LoggerInterface $logger)
    {
        $this->server = $server;
        $this->logger = $logger;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            return $this->server->respondToAccessTokenRequest($request, new Response());
        } catch (OAuthServerException $exception) {
            $this->logger->warning($exception->getMessage(), ['exception' => $exception]);
            return $exception->generateHttpResponse(new Response());
        } catch (Exception $exception) {
            return (new OAuthServerException($exception->getMessage(), 0, 'unknown_error', 500))
                ->generateHttpResponse(new Response());
        }
    }
}
