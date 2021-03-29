<?php

declare(strict_types=1);

use DI\Container;
use DI\ContainerBuilder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

require_once(__DIR__ . '/../vendor/autoload.php');

$builder = new ContainerBuilder();

$builder->addDefinitions([
    'config' => [
        'debug' => (bool)getenv('APP_DEBUG'),
    ]
]);

$container = $builder->build();

$app = AppFactory::createFromContainer($container);

$app->addErrorMiddleware((bool)getenv('APP_DEBUG'), true, true);

$app->get('/', function (RequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('{}');
    //throw new Exception('eye');
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();