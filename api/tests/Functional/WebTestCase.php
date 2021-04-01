<?php

declare(strict_types=1);

namespace Test\Functional;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;

class WebTestCase extends TestCase
{
    private ?App $app = null;
    private array $fixtures = [];

    protected static ?array $HEADERS = null;

    protected string $encryptedJwt;

    protected function setUp(): void
    {
        parent::setUp();
//        if (!self::$HEADERS) {
//            self::$HEADERS = $this->getHeaderLocalStorage();
//        }
    }

    protected function tearDown(): void
    {
        $this->dbPurge();

        /** @var ContainerInterface $container */
        $container = $this->app()->getContainer();
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        $em->getConnection()->close();

        $this->app = null;

        parent::tearDown();
    }

    protected function getTokens(array $postData, string $url): array
    {
        $response = $this->app()->handle(self::json('POST', $url, $postData));

        $content = (string)$response->getBody();

        /** @var array $data */
        $data = json_decode($content, true);

        return $data;
    }

    protected static function json(
        string $method,
        string $path,
        array $body = [],
        array $headers = []
    ): ServerRequestInterface {
        $request = self::request($method, $path)
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json');

        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }
        $request->getBody()->write(json_encode($body, JSON_THROW_ON_ERROR));

        return $request;
    }


    protected function getHeaderOAuthData(): array
    {
        return self::getHeaderLocalStorage();
    }

//    private function getHeaderCookie(): array
//    {
//        $postData = [
//            'login' => 'admin@test.com',
//            'password' => '123456',
//        ];
//
//        $response = $this->app()->handle(self::json('POST', '/v1/admins/login', $postData));
//        $oauth = FigResponseCookies::get($response, 'oauth')->getValue();
//        return [
//            'Cookie' => 'oauth=' . $oauth
//        ];
//    }

    private function getHeaderLocalStorage(): array
    {
        $postData = [
            'login' => getenv('OAUTH_USERNAME') ?? 'admin2@test.com',
            'password' => getenv('OAUTH_PASSWORD') ?? '123456',
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/users/login', $postData));

        $satrap1 = $response->getHeaderLine('X-Satrap-1');
        $satrap2 = $response->getHeaderLine('X-Satrap-2');

        return [
            'X-Satrap-1' => $satrap1,
            'X-Satrap-2' => $satrap2
        ];
    }

    protected static function request(string $method, string $path): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $path, ['REMOTE_ADDR' => '99.99.99.99']);
    }

    /**
     * @param array<string|int,string> $fixtures
     */
    protected function loadFixtures(array $fixtures): void
    {
        /** @var ContainerInterface $container */
        $container = $this->app()->getContainer();
        $loader = new Loader();
        foreach ($fixtures as $name => $class) {
            /** @var AbstractFixture $fixture */
            $fixture = $container->get($class);
            $loader->addFixture($fixture);
            $this->fixtures[$name] = $fixture;
        }
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        $executor = new ORMExecutor($em, new ORMPurger($em));
        $executor->execute($loader->getFixtures());
        $em->getConnection()->close();
    }

    protected function getFixture($name)
    {
        if (!array_key_exists($name, $this->fixtures)) {
            throw new InvalidArgumentException('Undefined fixture ' . $name);
        }

        return $this->fixtures[$name];
    }

    protected function dbPurge()
    {
        /** @var ContainerInterface $container */
        $container = $this->app()->getContainer();
        $em = $container->get(EntityManagerInterface::class);
        $ORMPurger = new ORMPurger($em);
        $ORMPurger->purge();
    }

    protected function app(): App
    {
        if ($this->app === null) {
            /** @var App */
            $this->app = (require __DIR__ . '/../../config/app.php')($this->container());
        }

        return $this->app;
    }

    private function container(): ContainerInterface
    {
        /** @var ContainerInterface */
        return require __DIR__ . '/../../config/container.php';
    }
}