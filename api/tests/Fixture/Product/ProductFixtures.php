<?php

declare(strict_types=1);

namespace Test\Fixture\Product;

use App\Model\Category\Entity\Category;
use App\Model\Product\Entity\Product;
use App\Model\Product\Type\DescriptionType;
use App\Model\Product\Type\NameType;
use App\Model\Product\Type\PriceType;
use App\Model\Type\UuidType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use App\Model\Category\Type\NameType as CategoryName;

class ProductFixtures extends AbstractFixture
{
    public static Product $PRODUCT;
    public static Product $SECOND_PRODUCT;

    public function load(ObjectManager $manager)
    {
        self::$PRODUCT = new Product(
            new NameType('Iphone'),
            new DescriptionType('Lala la la'),
            new PriceType(2.20),
            new Category(UuidType::generate(), new CategoryName('Categoryfixture'))
        );

        $manager->persist(self::$PRODUCT);

        self::$SECOND_PRODUCT = new Product(
            new NameType('Nokia'),
            new DescriptionType('Lala la la'),
            new PriceType(2.99)
        );

        $manager->persist(self::$SECOND_PRODUCT);

        $manager->flush();
    }
}