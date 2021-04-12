<?php

declare(strict_types=1);

namespace Test\Fixture\Product;

use App\Model\Category\Entity\Category;
use App\Model\Category\Type\NameType as CategoryNameType;
use App\Model\Product\Entity\Product;
use App\Model\Product\Type\DescriptionType;
use App\Model\Product\Type\NameType;
use App\Model\Product\Type\PriceType;
use App\Model\Tag\Entity\Tag;
use App\Model\Tag\Type\NameTagType;
use App\Model\Type\UuidType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends AbstractFixture
{
    public static Category $CATEGORY;

    public static Product $PRODUCT;
    public static Product $SECOND_PRODUCT;

    public static Tag $TAG;
    public static Tag $SECOND_TAG;

    public function load(ObjectManager $manager)
    {
        $products = $this->createProducts();
        foreach ($products as $product) {
            $manager->persist($product);
        }

        $tags = $this->createTags();
        foreach ($tags as $tag) {
            $manager->persist($tag);
        }

        $manager->flush();
    }

    public function createProducts(): array
    {
        return [
            self::$PRODUCT = new Product(
                new NameType('FirstProductNameProductFixture'),
                new DescriptionType('FirstProductDescriptionProductFixture'),
                new PriceType(2.55),
                self::$CATEGORY = new Category(
                    UuidType::generate(),
                    new CategoryNameType('CategoryNameProductFixture'),
                ),
            ),
            self::$SECOND_PRODUCT = new Product(
                new NameType('SecondProductNameProductFixture'),
                new DescriptionType('SecondProductDescriptionProductFixture'),
                new PriceType(4.55)
            ),
        ];
    }

    public function createTags(): array
    {
        return [
            self::$TAG = new Tag(
                new NameTagType('FirstTagProductFixture'),
            ),
            self::$SECOND_TAG = new Tag(
                new NameTagType('SecondTagProductFixture'),
            )
        ];
    }
}