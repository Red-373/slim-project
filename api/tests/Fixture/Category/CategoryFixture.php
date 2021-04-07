<?php

declare(strict_types=1);

namespace Test\Fixture\Category;

use App\Model\Category\Entity\Category;
use App\Model\Category\Type\NameType;
use App\Model\Product\Entity\Product;
use App\Model\Type\UuidType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends AbstractFixture
{
    public static Category $CATEGORY;
    public static Category $SECOND_CATEGORY;

    public static Product $PRODUCT;
    public static Product $SECOND_PRODUCT;

    public function load(ObjectManager $manager)
    {
        $categories = $this::createCategories();

        foreach($categories as $category) {
            $manager->persist($category);
        }

        $manager->flush();
    }

    public static function createCategories(): array
    {
        return [
            self::$CATEGORY = new Category(
                UuidType::generate(),
                new NameType('Smartphone'),
            ),
            self::$SECOND_CATEGORY = new Category(
                UuidType::generate(),
                new NameType('Phones'),
            ),
        ];
    }

    /*public function createProducts(): array
    {
        return [
            self::$CATEGORY = new Category(
                new UuidType(self::CORRECT_UUID),
                new NameType('Smartphone'),
            ),
            self::$SECOND_CATEGORY = new Category(
                new UuidType(self::CORRECT_UUID2),
                new NameType('Phones'),
            ),
        ];
    }*/
}