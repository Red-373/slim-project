<?php

declare(strict_types=1);

namespace Test\Fixture\Tag;

use App\Model\Product\Entity\Product;
use App\Model\Tag\Entity\Tag;
use App\Model\Tag\Type\NameTagType;
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

        $manager->flush();
    }

    public function createTags(): array
    {
        return [
            self::$TAG = new Tag(
                new NameTagType('Smartphones'),
            ),
            self::$SECOND_TAG = new Tag(
                new NameTagType('Apple'),
            )
        ];
    }
}