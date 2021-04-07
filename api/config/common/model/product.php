<?php

declare(strict_types=1);

use App\Model\Product\Entity\Product;
use App\Model\Product\Entity\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    ProductRepository::class => static function (ContainerInterface $container): ProductRepository {
        $em = $container->get(EntityManagerInterface::class);
        /** @var EntityRepository $repo */
        $repo = $em->getRepository(Product::class);

        return new ProductRepository($em, $repo);
    }
];
