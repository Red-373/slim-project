<?php

declare(strict_types=1);

namespace Test\Fixture\Product;

use App\Model\Category\Entity\Category;
use App\Model\Category\Type\NameType;
use App\Model\Product\Entity\Product;
use App\Model\Type\UuidType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends AbstractFixture
{
    public static Category $CATEGORY;
    public static Product $PRODUCT;

    public function load(ObjectManager $manager)
    {
        self::$CATEGORY = $category = new Category(
            new UuidType((string)UuidType::generate()),
            new NameType('Smartphone'));

        $manager->persist($category);

        $manager->flush();
    }
}