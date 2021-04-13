<?php

declare(strict_types=1);

namespace Test\Fixture\Tag;

use App\Model\Category\Entity\Category;
use App\Model\Category\Type\NameCategoryType as CategoryName;
use App\Model\Product\Entity\Product;
use App\Model\Product\Type\DescriptionProductType;
use App\Model\Product\Type\NameProductType;
use App\Model\Product\Type\PriceProductType;
use App\Model\Tag\Entity\Tag;
use App\Model\Tag\Type\NameTagType;
use App\Model\Type\UuidType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends AbstractFixture
{
    public static Tag $TAG;
    public static Tag $SECOND_TAG;

    public static Product $PRODUCT;

    public function load(ObjectManager $manager)
    {
        $tags = $this->createTags();
        foreach ($tags as $tag) {
            $manager->persist($tag);
        }

        $products = $this->createProduct();
        foreach ($products as $product) {
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function createTags(): array
    {
        return [
            self::$TAG = new Tag(
                new NameTagType('FirstTagTagFixture'),
            ),
            self::$SECOND_TAG = new Tag(
                new NameTagType('SecondTagTagFixture'),
            )
        ];
    }

    public function createProduct(): array
    {
        return [
            self::$PRODUCT = new Product(
                new NameProductType('ProductNameTagFixture'),
                new DescriptionProductType('ProductDescriptionTagFixture'),
                new PriceProductType(249.99),
                new Category(UuidType::generate(), new CategoryName('CategoryNameTagFixture'))
            )
        ];
    }
}