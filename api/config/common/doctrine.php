<?php

declare(strict_types=1);

use App\Infrastructure\Doctrine\Type\Category\NameTypeDb;
use App\Infrastructure\Doctrine\Type\Product\DescriptionTypeDb;
use App\Infrastructure\Doctrine\Type\Product\NameTypeDb as ProductNameTypeDb;
use App\Infrastructure\Doctrine\Type\Tag\NameTypeDb as TagNameTypeDb;
use App\Infrastructure\Doctrine\Type\Product\PriceTypeDb;
use App\Infrastructure\Doctrine\Type\UuidTypeDb;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\EventManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

return [
    EntityManagerInterface::class => function (ContainerInterface $container) {

        $settings = $container->get('config')['doctrine'];

        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['metadata_dirs'],
            $settings['dev_mode'],
            $settings['proxy_dir'],
            $settings['cache_dir'] ? new FilesystemCache($settings['cache_dir']) : new ArrayCache(),
            false
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy());

        foreach ($settings['types'] as $name => $class) {
            if (!Type::hasType($name)) {
                Type::addType($name, $class);
            }
        }

        $eventManager = new EventManager();

        foreach ($settings['subscribers'] as $name) {
            /** @var EventSubscriber $subscriber */
            $subscriber = $container->get($name);
            $eventManager->addEventSubscriber($subscriber);
        }

        return EntityManager::create(
            $settings['connection'],
            $config,
            $eventManager
        );
    },

    'config' => [
        'doctrine' => [
            'dev_mode' => false,
            'cache_dir' => __DIR__ . '/../../var/cache/doctrine/cache',
            'proxy_dir' => __DIR__ . '/../../var/cache/doctrine/proxy',
            'connection' => [
                'driver' => 'pdo_pgsql',
                'host' => getenv('DB_HOST'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'dbname' => getenv('DB_NAME'),
                'charset' => 'utf-8',
            ],
            'subscribers' => [],
            'metadata_dirs' => [
                __DIR__ . '/../../src/Model/Category/Entity',
                __DIR__ . '/../../src/Model/Product/Entity',
                __DIR__ . '/../../src/Model/Tag/Entity',
            ],
            'types' => [
                UuidTypeDb::NAME => UuidTypeDb::class,
                NameTypeDb::NAME => NameTypeDb::class,

                ProductNameTypeDb::NAME => ProductNameTypeDb::class,
                DescriptionTypeDb::NAME => DescriptionTypeDb::class,
                PriceTypeDb::NAME => PriceTypeDb::class,

                TagNameTypeDb::NAME => TagNameTypeDb::class,
            ],
        ]
    ]
];
