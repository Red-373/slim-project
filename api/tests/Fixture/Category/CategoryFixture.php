<?php

declare(strict_types=1);

namespace Test\Fixture\Category;

use App\Model\Category\Entity\Category;
use App\Model\Category\Type\NameType;
use App\Model\Product\Entity\Product;
use App\Model\Product\Type\DescriptionType;
use App\Model\Product\Type\NameType as ProductNameType;
use App\Model\Product\Type\PriceType;
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

        foreach ($categories as $category) {
            $manager->persist($category);
        }

        $products = $this::createProducts();
        foreach ($products as $product) {
            $manager->persist($product);
        }

        $manager->flush();
    }

    public static function createCategories(): array
    {
        return [
            self::$CATEGORY = new Category(
                UuidType::generate(),
                new NameType('CategoryFixtureCategoryName'),
            ),
            self::$SECOND_CATEGORY = new Category(
                UuidType::generate(),
                new NameType('CategoryFixtureCategoryNameSec'),
            ),
        ];
    }

    public static function createProducts(): array
    {
        return [
            self::$PRODUCT = new Product(
                new ProductNameType('CategoryFixtureProductName'),
                new DescriptionType('CategoryFixtureProductDesc'),
                new PriceType(2.55),
                self::$CATEGORY
            ),
            self::$SECOND_PRODUCT = new Product(
                new ProductNameType('CategoryFixtureProductNameSec'),
                new DescriptionType('CategoryFixtureProductDescSec'),
                new PriceType(4.55)
            ),
        ];
    }
}