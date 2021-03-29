<?php
declare(strict_types=1);

use App\Console\Command\CacheClearCommand;

return [
    'dependencies' => [
        'factories' => [
            CacheClearCommand::class => Infrastructure\App\Console\Command\CacheClearCommandFactory::class,
        ],
    ],
    'console' => [
        'commands' => [
            CacheClearCommand::class,
        ],
        'cachePaths' => [
            'doctrine' => 'var/cache/doctrine',
            'twig' => 'var/cache/twig',
        ]
    ],
];
