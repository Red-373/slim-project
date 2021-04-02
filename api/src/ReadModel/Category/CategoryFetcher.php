<?php

declare(strict_types=1);

namespace App\ReadModel\Category;

use App\Model\Category\Command\Category\Command;
use App\Model\Category\Command\Find\Command as FindCommand;
use App\Model\Category\Entity\Category;
use App\Model\Category\Entity\CategoryRepository;
use App\Model\Type\UuidType;

class CategoryFetcher
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCategory(Command $command): array
    {
        $categoryId = new UuidType($command->id);

        $category = $this->repository->getCategory($categoryId);

        return $this->convertCategoryToArray($category);
    }

    public function getCategories(): array
    {
        return array_map([$this, 'convertCategoryToArray'], $this->repository->getCategories());
    }

    public function findCategoryByName(FindCommand $command): array
    {
        $categories = $this->repository->findCategoryByName($command->name);

        $array = [];

        foreach ($categories as $category) {
            $array[] = $this->convertCategoryToArray($category);
        }

        return $array;
    }

    private function convertCategoryToArray(Category $category): array
    {
        return [
            'id' => $category->getId()->getValue(),
            'name' => $category->getName()->getValue(),
        ];
    }
}
