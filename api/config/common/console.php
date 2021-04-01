<?php

declare(strict_types=1);

use App\Console\HelloCommand;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\UpToDateCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Psr\Container\ContainerInterface;

return [
    DependencyFactory::class => static function (ContainerInterface $container): DependencyFactory {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);

        $configuration = new Configuration();
        $storageConfiguration = new TableMetadataStorageConfiguration();

        $configuration->addMigrationsDirectory('App\Data\Migration',__DIR__ . '/../../src/Data/Migration');
        $configuration->setAllOrNothing(true);
        $configuration->setMetadataStorageConfiguration($storageConfiguration);
        $storageConfiguration->setTableName('migrations');

        return DependencyFactory::fromEntityManager(
            new ExistingConfiguration($configuration),
            new ExistingEntityManager($entityManager),
        );
    },
    MigrateCommand::class => static function (ContainerInterface $container): MigrateCommand {
        return new MigrateCommand($container->get(DependencyFactory::class));
    },
    ExecuteCommand::class => static function (ContainerInterface $container): ExecuteCommand {
        return new ExecuteCommand($container->get(DependencyFactory::class));
    },
    LatestCommand::class => static function (ContainerInterface $container): LatestCommand {
        return new LatestCommand($container->get(DependencyFactory::class));
    },
    StatusCommand::class => static function (ContainerInterface $container): StatusCommand {
        return new StatusCommand($container->get(DependencyFactory::class));
    },
    UpToDateCommand::class => static function (ContainerInterface $container): UpToDateCommand {
        return new UpToDateCommand($container->get(DependencyFactory::class));
    },
    'config' => [
        'console' => [
            'commands' => [
                HelloCommand::class,
                ValidateSchemaCommand::class,

                ExecuteCommand::class,
                MigrateCommand::class,
                LatestCommand::class,
                StatusCommand::class,
                UpToDateCommand::class,
            ],
        ],
    ],
];