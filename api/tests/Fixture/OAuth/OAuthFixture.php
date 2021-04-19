<?php

declare(strict_types=1);

namespace Test\Fixture\OAuth;

use App\Model\OAuth\Entity\AccessTokenEntity;
use App\Model\OAuth\Entity\ClientEntity;
use App\Model\OAuth\Entity\ScopeEntity;
use App\Model\User\Entity\User;
use App\Model\User\Type\EmailType;
use App\Model\User\Type\PasswordType;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use League\OAuth2\Server\CryptKey;

class OAuthFixture extends AbstractFixture
{
    public static User $USER;
    //public static string $TOKEN;

    public function load(ObjectManager $manager)
    {
        self::$USER = new User(
            new EmailType('oauth@example.com'),
            new PasswordType('password')
        );

        $manager->persist(self::$USER);

        /*$token = new AccessTokenEntity();
        $token->setIdentifier(bin2hex(random_bytes(40)));
        $token->setUserIdentifier(self::$USER->getId()->getValue());
        $token->setExpiryDateTime(new DateTimeImmutable('+1 hour'));
        $token->setClient(new ClientEntity('app'));
        $token->addScope(new ScopeEntity('common'));
        $key = new CryptKey(__DIR__ . '/../../../private.key');
        $token->setPrivateKey($key);

        $manager->persist($token);

        self::$TOKEN =(string)$token;*/

        $manager->flush();
    }

    /*public function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . self::$TOKEN,
        ];
    }*/
}
