#!/usr/bin/env php
<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;

require_once(__DIR__ . '/../vendor/autoload.php');

$cli = new Application('Console ');

$cli->run();