<?php

declare(strict_types=1);

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

require_once(__DIR__ . '/../vendor/autoload.php');

$app = \Slim\Factory\AppFactory::create();

$app->get('/', function (RequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('{}');
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();