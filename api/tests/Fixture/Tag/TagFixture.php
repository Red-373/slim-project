<?php

declare(strict_types=1);

namespace Test\Fixture\Tag;

use App\Model\Tag\Entity\Tag;
use App\Model\Tag\Type\NameTagType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends AbstractFixture
{
    public static Tag $TAG;
    public static Tag $SECOND_TAG;

    public function load(ObjectManager $manager)
    {
        self::$TAG = new Tag(
            new NameTagType('Smartphones'),
        );

        $manager->persist(self::$TAG);

        self::$SECOND_TAG = new Tag(
            new NameTagType('Apple'),
        );

        $manager->persist(self::$SECOND_TAG);

        $manager->flush();
    }
}