#!/usr/bin/env php
<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

require_once(__DIR__ . '/../vendor/autoload.php');

/** @var ContainerInterface $container */
$container = require_once(__DIR__ . '/../config/container.php');

$cli = new Application( );

$commands = $container->get('config')['console']['commands'];
//print_r($container->get('config'));die;
foreach ($commands as $command) {
    $cli->add($container->get($command));
}

$cli->run();