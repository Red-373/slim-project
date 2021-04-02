<?php

declare(strict_types=1);

namespace App\Model\Product\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProductRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        /** @var EntityRepository $repo */
        $repo = $em->getRepository(Product::class);
        $this->repo = $repo;
        $this->em = $em;
    }

    public function has(Product $product): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $product->getName()->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function addProduct(Product $product): void
    {
        $this->em->persist($product);
    }
}