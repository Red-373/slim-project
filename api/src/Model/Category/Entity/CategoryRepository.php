<?php

declare(strict_types=1);

namespace App\Model\Category\Entity;

use App\Model\Category\Type\NameType;
use App\Model\Type\UuidType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;
use InvalidArgumentException;

class CategoryRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    public function getCategory(UuidType $id): Category
    {
        /** @var Category|null $category */
        $category = $this->repo->find($id->getValue());

        return $this->fetch($category);
    }

    public function findCategoryByName(string $name): array
    {
        $category = $this->repo->createQueryBuilder('t')
            ->andWhere('LOWER (t.name) LIKE :name')
            ->setParameter(':name', '%' . mb_strtolower($name) . '%')
            ->getQuery()->getResult();

        return $this->fetchAll($category);
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->repo->findAll();
    }

    public function addCategory(Category $category): void
    {
        $this->em->persist($category);
    }

    public function has(UuidType $id): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $id->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function hasByName(NameType $name): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.name = :name')
                ->setParameter(':name', $name->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }


    private function fetch(?Category $category): Category
    {
        if (!$category) {
            throw new DomainException('Not found category.' );
        }

        return $category;
    }

    /**
     * @param array $categories
     * @return Category[]
     */
    private function fetchAll(array $categories): array
    {
        $allCategories = [];
        foreach ($categories as $category) {
            if (!$category) {
                throw new InvalidArgumentException('Not found category.');
            }

            $allCategories[] = $category;
        }

        return $allCategories;
    }
}
