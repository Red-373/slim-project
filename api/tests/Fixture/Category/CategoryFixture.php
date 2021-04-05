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
    public const CORRECT_UUID = '642abaa5-481e-4a60-ac3e-b7665f5b53a0';
    public const UNDEFINED_UUID = 'b4eb097b-1b32-4121-bccb-41bdbb240492';
    public const INCORRECT_UUID = 'a0cd6990-10bf-43cd-a5f6-c037c4b969eeE';

    public static Category $CATEGORY;

    public function load(ObjectManager $manager)
    {
        self::$CATEGORY = new Category(
            new UuidType(self::CORRECT_UUID),
            new NameType('Smartphone'),
        );

        $manager->persist(self::$CATEGORY);

        $manager->flush();
    }
}