<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;

require_once(__DIR__ . '/../vendor/autoload.php');

/** @var ContainerInterface $container */
$container = require_once(__DIR__ . '/../config/container.php');

/** @var App $app */
$app = (require_once(__DIR__ . '/../config/app.php'))($container);

$app->run();
