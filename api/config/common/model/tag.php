<?php

declare(strict_types=1);

use App\Model\Tag\Entity\Tag;
use App\Model\Tag\Entity\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    TagRepository::class => static function (ContainerInterface $container): TagRepository {
        $em = $container->get(EntityManagerInterface::class);
        /** @var EntityRepository $repo */
        $repo = $em->getRepository(Tag::class);
        return new TagRepository($em, $repo);
    }
];
