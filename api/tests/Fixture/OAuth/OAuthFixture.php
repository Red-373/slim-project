<?php

declare(strict_types=1);

namespace Test\Fixture\OAuth;

use App\Model\User\Entity\User;
use App\Model\User\Type\EmailType;
use App\Model\User\Type\PasswordType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class OAuthFixture extends AbstractFixture
{
    public static User $USER;

    public function load(ObjectManager $manager)
    {
        self::$USER = new User(
            new EmailType('oauth@example.com'),
            new PasswordType('password')
        );

        $manager->persist(self::$USER);

        $manager->flush();
    }
}
