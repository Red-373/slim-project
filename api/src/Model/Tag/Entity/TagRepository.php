<?php

declare(strict_types=1);

namespace App\Model\Tag\Entity;

use App\Model\Type\UuidType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class TagRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    public function has(UuidType $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function getTag(UuidType $id): Tag
    {
        /** @var Tag|null $product */
        $product = $this->repo->find($id->getValue());

        return $this->fetch($product);
    }

    private function fetch(?Tag $tag): Tag
    {
        if (!$tag) {
            throw new DomainException('Not found product.');
        }

        return $tag;
    }
}