<?php

declare(strict_types=1);

namespace App\Model\User\Command\LogoutAll;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use Lcobucci\JWT\Configuration;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

class Handler
{
    private AccessTokenRepositoryInterface $accessTokenRepository;
    private Flusher $flusher;
    private Configuration $jwtParser;

    public function __construct(AccessTokenRepositoryInterface $accessTokenRepository, Flusher $flusher, Configuration $jwtParser)
    {
        $this->accessTokenRepository = $accessTokenRepository;
        $this->flusher = $flusher;
        $this->jwtParser = $jwtParser;
    }

    public function handle(Command $command): void
    {
        $jwt = $command->jwt;
        $parsedJwt = $this->jwtParser->parser()->parse($jwt)->claims()->all();
        $userId = $parsedJwt['sub'];

        $accessTokens = $this->accessTokenRepository->getAccessTokensByUserId($userId);
        foreach ($accessTokens as $token) {
            $this->accessTokenRepository->revokeAccessToken($token->getIdentifier());
        }

        $this->flusher->flush();
    }
}