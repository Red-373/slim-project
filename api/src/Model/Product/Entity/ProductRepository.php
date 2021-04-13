<?php

declare(strict_types=1);

namespace App\Model\Product\Entity;

use App\Model\Product\Type\NameProductType;
use App\Model\Type\UuidType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class ProductRepository
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

    public function hasProductByName(NameProductType $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function getProduct(UuidType $id): Product
    {
        /** @var Product|null $product */
        $product = $this->repo->find($id->getValue());

        return $this->fetch($product);
    }

    public function addProduct(Product $product): void
    {
        $this->em->persist($product);
    }

    private function fetch(?Product $product): Product
    {
        if (!$product) {
            throw new DomainException('Not found product.');
        }

        return $product;
    }
}
