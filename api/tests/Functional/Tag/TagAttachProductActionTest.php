<?php

declare(strict_types=1);

namespace Test\Functional\Tag;

use App\Model\Type\UuidType;
use Test\Fixture\Tag\TagFixture;
use Test\Functional\WebTestCase;

class TagAttachProductActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([TagFixture::class]);
    }

    public function testSuccess(): void
    {
        $tagId = TagFixture::$TAG->getId()->getValue();
        $productsId = TagFixture::$PRODUCT->getId()->getValue();
        $body = [
            'id' => $tagId,
            'products' => [
                $productsId
            ]
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/tags/attach/products', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testFailEmptyRequest(): void
    {
        $body = [
            'id' => '',
            'products' => [
                ''
            ]
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/tags/attach/products', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This value should not be blank.',
                'products[0]' => 'This value should not be blank.'
            ]
        ];
        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailIncorrectValues(): void
    {
        $body = [
            'id' => 'NotValidId',
            'products' => [
                'NotValidId'
            ]
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/tags/attach/products', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This is not a valid UUID.',
                'products[0]' => 'This is not a valid UUID.'
            ]
        ];
        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailNotFoundTag(): void
    {
        $undefinedId = UuidType::generate()->getValue();
        $productsId = TagFixture::$PRODUCT->getId()->getValue();
        $body = [
            'id' => $undefinedId,
            'products' => [
                $productsId
            ]
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/tags/attach/products', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'message' => 'Not found tag. Tag id = ' . $undefinedId . '.'
        ];
        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailNotFoundProduct(): void
    {
        $tagId = TagFixture::$TAG->getId()->getValue();
        $undefinedId = UuidType::generate()->getValue();
        $body = [
            'id' => $tagId,
            'products' => [
                $undefinedId
            ]
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/tags/attach/products', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'message' => 'Not found product. Product id = ' . $undefinedId . '.'
        ];
        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }
}