<?php

declare(strict_types=1);

namespace App\Model\Product\Entity;

use App\Model\Product\Type\NameType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProductRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    public function hasProductByName(NameType $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function addProduct(Product $product): void
    {
        $this->em->persist($product);
    }
}
