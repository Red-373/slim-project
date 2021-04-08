<?php

declare(strict_types=1);

namespace Test\Functional\Product;

use App\Model\Type\UuidType;
use Test\Fixture\Product\ProductFixture;
use Test\Functional\WebTestCase;

class ProductAttachTagActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([ProductFixture::class]);
    }

    public function testSuccess(): void
    {
        $productId = ProductFixture::$PRODUCT->getId()->getValue();
        $tagId = ProductFixture::$TAG->getId()->getValue();

        $body = [
            'id' => $productId,
            'tags' => [
                $tagId
            ]
        ];

        $request = self::json('POST', '/v1/products/attach/tags')
            ->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testFailEmptyRequest(): void
    {
        $body = [
            'id' => '',
            'tags' => [
                ''
            ]
        ];
        $request = self::json('POST', '/v1/products/attach/tags')->withParsedBody($body);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This value should not be blank.',
                'tags[0]' => 'This value should not be blank.'
            ]
        ];

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailIncorrectValues(): void
    {
        $body = [
            'id' => 'NotValidId',
            'tags' => [
                'NotValidId'
            ]
        ];
        $request = self::json('POST', '/v1/products/attach/tags')->withParsedBody($body);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This is not a valid UUID.',
                'tags[0]' => 'This is not a valid UUID.'
            ]
        ];

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailNotFoundProduct(): void
    {
        $undefinedId = UuidType::generate()->getValue();
        $tagId = ProductFixture::$TAG->getId()->getValue();

        $body = [
            'id' => $undefinedId,
            'tags' => [
                $tagId
            ]
        ];
        $request = self::json('POST', '/v1/products/attach/tags')->withParsedBody($body);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'message' => 'Not found product. Product id = ' . $undefinedId . '.'
        ];

        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailNotFoundTag(): void
    {
        $productId = ProductFixture::$PRODUCT->getId()->getValue();
        $undefinedId = UuidType::generate()->getValue();

        $body = [
            'id' => $productId,
            'tags' => [
                $undefinedId
            ]
        ];
        $request = self::json('POST', '/v1/products/attach/tags')->withParsedBody($body);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'message' => 'Not found tag. Tag id = ' . $undefinedId . '.'
        ];

        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }
}