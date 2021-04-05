<?php

declare(strict_types=1);

use App\Model\Category\Entity\Category;
use App\Model\Category\Entity\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    CategoryRepository::class => static function (ContainerInterface $container): CategoryRepository {
        $em = $container->get(EntityManagerInterface::class);
        /** @var EntityRepository $repo */
        $repo = $em->getRepository(Category::class);

        return new CategoryRepository($em, $repo);
    }
];