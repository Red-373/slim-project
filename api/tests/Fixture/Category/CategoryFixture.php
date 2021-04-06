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
    private const CORRECT_UUID = '642abaa5-481e-4a60-ac3e-b7665f5b53a0';
    private const CORRECT_UUID2 = '642abaa5-481e-4a60-ac3e-b7665f5b53a4';

    public static Category $CATEGORY;
    public static Category $SECOND_CATEGORY;

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
                new UuidType(self::CORRECT_UUID),
                new NameType('Smartphone'),
            ),
            self::$SECOND_CATEGORY = new Category(
                new UuidType(self::CORRECT_UUID2),
                new NameType('Phones'),
            ),
        ];
    }
}