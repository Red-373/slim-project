<?php

declare(strict_types=1);

namespace Test\Fixture\Product;

use App\Model\Product\Entity\Product;
use App\Model\Product\Type\DescriptionType;
use App\Model\Product\Type\NameType;
use App\Model\Product\Type\PriceType;
use App\Model\Type\UuidType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Test\Fixture\Category\CategoryFixture;

class ProductFixtures extends AbstractFixture
{
    public static Product $PRODUCT;


    public function load(ObjectManager $manager)
    {
        self::$PRODUCT = new Product(
            new UuidType((string)UuidType::generate()),
            new NameType('Iphone 13'),
            new DescriptionType('Lala la la'),
            new PriceType(2.20),
            CategoryFixture::$CATEGORY
        );

        $manager->persist(self::$PRODUCT);

        $manager->flush();
    }
}