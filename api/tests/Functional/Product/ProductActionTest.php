<?php

declare(strict_types=1);

namespace Test\Functional\Product;

use App\Model\Type\UuidType;
use Test\Fixture\Product\ProductFixture;
use Test\Functional\WebTestCase;

class ProductActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([ProductFixture::class]);
    }

    public function testSuccess(): void
    {
        $product = ProductFixture::$PRODUCT;
        $queryParams = [
            'id' => $product->getId()->getValue()
        ];

        $request = self::json('GET', '/v1/products', [], self::$HEADERS)
            ->withQueryParams($queryParams);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $product = [
            'id' => $product->getId()->getValue(),
            'name' => $product->getName()->getValue(),
            'description' => $product->getDescription()->getValue(),
            'price' => $product->getPrice()->getValue(),
            'category_id' => $product->getCategory()->getId()->getValue(),
        ];
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals($product, $data);
    }

    public function testFailEmptyId(): void
    {
        $queryParams = [
            'id' => ''
        ];

        $request = self::json('GET', '/v1/products', [], self::$HEADERS)
            ->withQueryParams($queryParams);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This value should not be blank.'
            ]
        ];
        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailIncorrectId(): void
    {
        $queryParams = [
            'id' => 'InvalidProductId'
        ];

        $request = self::json('GET', '/v1/products', [], self::$HEADERS)
            ->withQueryParams($queryParams);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This is not a valid UUID.'
            ]
        ];

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailNotFoundProduct(): void
    {
        $undefinedId = UuidType::generate()->getValue();
        $queryParams = [
            'id' => $undefinedId
        ];

        $request = self::json('GET', '/v1/products', [], self::$HEADERS)
            ->withQueryParams($queryParams);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        $message = [
            'message' => 'Not found product.'
        ];

        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($message, $data);
    }
}