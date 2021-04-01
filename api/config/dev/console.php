<?php

declare(strict_types=1);

use App\Console\FixtureLoadCommand;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Psr\Container\ContainerInterface;

return [
    DiffCommand::class => static function (ContainerInterface $container): DiffCommand {
        return new DiffCommand($container->get(DependencyFactory::class));
    },
    FixtureLoadCommand::class => static function (ContainerInterface $container): FixtureLoadCommand {
        $config = $container->get('config')['console'];

        $em = $container->get(\Doctrine\ORM\EntityManagerInterface::class);

        return new FixtureLoadCommand(
            $em,
            $config['fixture_paths']
        );
    },
    'config' => [
        'console' => [
            'commands' => [
                FixtureLoadCommand::class,

                CreateCommand::class,
                DropCommand::class,

                DiffCommand::class,
                GenerateCommand::class
            ],
            'fixture_paths' => [
                __DIR__ . '/../../tests/Fixture'
            ]
        ],
    ],
];