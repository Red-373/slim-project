<?php

declare(strict_types=1);

namespace App\Model\Category\Entity;

use App\Model\Category\Type\NameType;
use App\Model\Type\UuidType;
use InvalidArgumentException;

class CategoryRepository
{
    /** @var Category[] */
    private array $categories;

    public function __construct()
    {
        $this->categories = [
            new Category(new UuidType('0f5d4faa-d38e-4b61-b8d4-72b950d95382'), new NameType('Зеленый')),
            new Category(new UuidType('0f5d4faa-d38e-4b61-b8d4-72b950d95381'), new NameType('Черный')),
            new Category(new UuidType('0f5d4faa-d38e-4b61-b8d4-72b950d95380'), new NameType('Английский'))
        ];
    }

    public function getCategory(UuidType $id): Category
    {
        foreach ($this->categories as $category) {
            if ($category->getId()->isEqualTo($id)) {
                return $category;
            }
        }

        throw new InvalidArgumentException('Not found id');
    }

    /**
     * @param NameType $name
     * @return Category[]
     */
    public function findCategoryByName(NameType $name): array
    {
        $categories = [];

        foreach ($this->categories as $category) {
            if (mb_stripos($category->getName()->getValue(), $name->getValue()) !== false) {
                $categories[] = $category;
            }
        }

        if (!isset($categories)) {
            throw new InvalidArgumentException('Not found name');
        }

        return $categories;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
    }

    public function has(Category $anotherCategory): bool
    {
        foreach ($this->categories as $category) {
            if ($category->getName()->isEqualTo($anotherCategory->getName())) {
                return true;
            }
        }

        return false;
    }
}
