<?php

declare(strict_types=1);

use App\Model\OAuth\Entity\AccessTokenEntity;
use App\Model\OAuth\Entity\RefreshTokenEntity;
use App\Model\OAuth\Repository\AccessTokenRepository;
use App\Model\OAuth\Repository\ClientRepository;
use App\Model\OAuth\Repository\RefreshTokenRepository;
use App\Model\OAuth\Repository\ScopeRepository;
use App\Model\OAuth\Repository\UserRepository;
use App\Model\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use League\OAuth2\Server;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Psr\Container\ContainerInterface;

return [
    Server\AuthorizationServer::class => function (ContainerInterface $container) {
        $config = $container->get('config')['oauth'];

        $clientRepository = $container->get(Server\Repositories\ClientRepositoryInterface::class);
        $scopeRepository = $container->get(Server\Repositories\ScopeRepositoryInterface::class);
        $accessTokenRepository = $container->get(Server\Repositories\AccessTokenRepositoryInterface::class);
        $refreshTokenRepository = $container->get(Server\Repositories\RefreshTokenRepositoryInterface::class);
        $userRepository = $container->get(Server\Repositories\UserRepositoryInterface::class);

        $server = new Server\AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            new Server\CryptKey($config['private_key_path'], null, false),
            $config['encryption_key']
        );

        $grant = new Server\Grant\PasswordGrant($userRepository, $refreshTokenRepository);
        $grant->setRefreshTokenTTL(new DateInterval('P1M'));
        $server->enableGrantType($grant, new DateInterval('PT1H'));

        $grant = new Server\Grant\RefreshTokenGrant($refreshTokenRepository);
        $grant->setRefreshTokenTTL(new DateInterval('P1M'));
        $server->enableGrantType($grant, new DateInterval('PT1H'));

        return $server;
    },
    Server\ResourceServer::class => function (ContainerInterface $container) {
        $config = $container->get('config')['oauth'];

        $accessTokenRepository = $container->get(Server\Repositories\AccessTokenRepositoryInterface::class);

        return new Server\ResourceServer(
            $accessTokenRepository,
            new Server\CryptKey($config['public_key_path'], null, false)
        );
    },
    Server\Middleware\ResourceServerMiddleware::class => function (ContainerInterface $container) {
        return new Server\Middleware\ResourceServerMiddleware($container->get(Server\ResourceServer::class));
    },
    Server\Repositories\ClientRepositoryInterface::class => function (ContainerInterface $container) {
        $config = $container->get('config')['oauth'];
        return new ClientRepository($config['clients']);
    },
    Server\Repositories\ScopeRepositoryInterface::class => function () {
        return new ScopeRepository();
    },
    Server\Repositories\AccessTokenRepositoryInterface::class => function (ContainerInterface $container): AccessTokenRepositoryInterface {
        $em = $container->get(EntityManagerInterface::class);

        /** @var EntityRepository $repo */
        $repo = $em->getRepository(AccessTokenEntity::class);

        return new AccessTokenRepository($em, $repo);
    },
    Server\Repositories\RefreshTokenRepositoryInterface::class => function (ContainerInterface $container): RefreshTokenRepositoryInterface {
        $em = $container->get(EntityManagerInterface::class);

        /** @var EntityRepository $repo */
        $repo = $em->getRepository(RefreshTokenEntity::class);

        return new RefreshTokenRepository($em, $repo);
    },
    Server\Repositories\UserRepositoryInterface::class => static function (ContainerInterface $container): Server\Repositories\UserRepositoryInterface {
        $em = $container->get(EntityManagerInterface::class);

        /** @var EntityRepository $repo */
        $repo = $em->getRepository(User::class);

        return new UserRepository($em, $repo);
    },
    Configuration::class => static function (): Configuration {
        return Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText('')
        );
    },

    'config' => [
        'oauth' => [
            'public_key_path' => __DIR__ . '/../../public.key',
            'private_key_path' => __DIR__ . '/../../private.key',
            'encryption_key' => 'lxZFUEsBCJ2Yb14IF2ygAHI5N4+ZAUXXaSeeJm6+twsUmIen',
            'clients' => [
                'app' => [
                    'secret' => null,
                    'name' => 'App',
                    'redirect_uri' => null,
                    'is_confidential' => false,
                ],
            ],
        ],
    ],
];
