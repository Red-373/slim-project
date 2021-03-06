<?php

declare(strict_types=1);

namespace Test\Functional\Category;

use App\Model\Type\UuidType;
use Test\Fixture\Category\CategoryFixture;
use Test\Functional\WebTestCase;

class CategoryAttachProductActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([CategoryFixture::class]);
    }

    public function testSuccess(): void
    {
        $id = CategoryFixture::$CATEGORY->getId()->getValue();
        $productId = CategoryFixture::$SECOND_PRODUCT->getId()->getValue();
        $body = [
            'id' => $id,
            'products' => [
                $productId,
            ]
        ];

        $request = self::json('POST', '/v1/categories/attach/products', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testGuest()
    {
        $id = CategoryFixture::$CATEGORY->getId()->getValue();
        $productId = CategoryFixture::$SECOND_PRODUCT->getId()->getValue();
        $body = [
            'id' => $id,
            'products' => [
                $productId,
            ]
        ];

        $request = self::json('POST', '/v1/categories/attach/products', $body);
        $response = $this->app()->handle($request);

        self::assertEquals(401, $response->getStatusCode());
    }

    public function testFailEmptyRequest(): void
    {
        $body = [
            'id' => '',
            'products' => [
                '',
            ]
        ];

        $request = self::json('POST', '/v1/categories/attach/products', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
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

    public function testFailInvalidRequest(): void
    {
        $body = [
            'id' => 'str',
            'products' => [
                'str',
            ]
        ];

        $request = self::json('POST', '/v1/categories/attach/products', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
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

    public function testFailNotFoundCategory(): void
    {
        $undefinedId = UuidType::generate()->getValue();
        $undefinedProductId = UuidType::generate()->getValue();
        $body = [
            'id' => $undefinedId,
            'products' => [
                $undefinedProductId
            ]
        ];

        $request = self::json('POST', '/v1/categories/attach/products', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $message = [
            'message' => 'Not found category id = ' . $undefinedId . '.'
        ];
        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($message, $data);
    }

    public function testFailNotFoundProduct(): void
    {
        $id = CategoryFixture::$CATEGORY->getId()->getValue();
        $undefinedProductId = UuidType::generate()->getValue();
        $body = [
            'id' => $id,
            'products' => [
                $undefinedProductId
            ]
        ];

        $request = self::json('POST', '/v1/categories/attach/products', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $message = [
            'message' => 'Not found product. Product id = ' . $undefinedProductId . '.'
        ];
        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($message, $data);

    }

    public function testFailHaveCategoryId(): void
    {
        $id = CategoryFixture::$CATEGORY->getId()->getValue();
        $productId = CategoryFixture::$PRODUCT->getId()->getValue();
        $body = [
            'id' => $id,
            'products' => [
                $productId
            ]
        ];

        $request = self::json('POST', '/v1/categories/attach/products', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $message = [
            'message' => 'This product ' . $productId . ' have category id.'
        ];
        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($message, $data);
    }
}