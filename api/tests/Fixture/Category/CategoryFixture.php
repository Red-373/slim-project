<?php

declare(strict_types=1);

namespace Test\Fixture\Category;

use App\Model\Category\Entity\Category;
use App\Model\Category\Type\NameCategoryType;
use App\Model\OAuth\Entity\AccessTokenEntity;
use App\Model\OAuth\Entity\ClientEntity;
use App\Model\OAuth\Entity\ScopeEntity;
use App\Model\Product\Entity\Product;
use App\Model\Product\Type\DescriptionProductType;
use App\Model\Product\Type\NameProductType as ProductNameType;
use App\Model\Product\Type\PriceProductType;
use App\Model\Type\UuidType;
use App\Model\User\Entity\User;
use App\Model\User\Type\EmailType;
use App\Model\User\Type\PasswordType;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use League\OAuth2\Server\CryptKey;

class CategoryFixture extends AbstractFixture
{
    public static Category $CATEGORY;
    public static Category $SECOND_CATEGORY;

    public static Product $PRODUCT;
    public static Product $SECOND_PRODUCT;

    //public static User $USER;
    //public static string $TOKEN;

    public function load(ObjectManager $manager)
    {
        $categories = $this->createCategories();

        foreach ($categories as $category) {
            $manager->persist($category);
        }

        $products = $this->createProducts();
        foreach ($products as $product) {
            $manager->persist($product);
        }

        //$this->createAuthToken($manager);

        $manager->flush();
    }

    /*public static function getAuthHeader(): array
    {
        return [
            'Authorization' => 'Bearer ' . self::$TOKEN,
        ];
    }*/

    private function createCategories(): array
    {
        return [
            self::$CATEGORY = new Category(
                UuidType::generate(),
                new NameCategoryType('CategoryFixtureCategoryName'),
            ),
            self::$SECOND_CATEGORY = new Category(
                UuidType::generate(),
                new NameCategoryType('CategoryFixtureCategoryNameSec'),
            ),
        ];
    }

    private function createProducts(): array
    {
        return [
            self::$PRODUCT = new Product(
                new ProductNameType('CategoryFixtureProductName'),
                new DescriptionProductType('CategoryFixtureProductDesc'),
                new PriceProductType(2.55),
                self::$CATEGORY
            ),
            self::$SECOND_PRODUCT = new Product(
                new ProductNameType('CategoryFixtureProductNameSec'),
                new DescriptionProductType('CategoryFixtureProductDescSec'),
                new PriceProductType(4.55)
            ),
        ];
    }

    /*private function createAuthToken(ObjectManager $manager): void
    {
        self::$USER = new User(
            new EmailType('categoryfixture@example.com'),
            new PasswordType('password')
        );

        $manager->persist(self::$USER);

        $token = new AccessTokenEntity();
        $token->setIdentifier(bin2hex(random_bytes(40)));
        $token->setUserIdentifier(self::$USER->getId()->getValue());
        $token->setExpiryDateTime(new DateTimeImmutable('+1 hour'));
        $token->setClient(new ClientEntity('app'));
        $token->addScope(new ScopeEntity('common'));
        $key = new CryptKey(__DIR__ . '/../../../private.key');
        $token->setPrivateKey($key);

        $manager->persist($token);

        self::$TOKEN = (string)$token;
    }*/
}