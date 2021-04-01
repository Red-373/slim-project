<?php

declare(strict_types=1);

namespace Test\Fixture\Category;

use App\Model\Category\Entity\Category;
use App\Model\Category\Type\NameType;
use App\Model\Type\UuidType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends AbstractFixture
{
    public static Category $CATEGORY;

    public function load(ObjectManager $manager)
    {
        self::$CATEGORY = $category = new Category(
            new UuidType((string)UuidType::generate()),
            new NameType('Чай'));

        $manager->persist($category);

        $manager->flush();
    }
}