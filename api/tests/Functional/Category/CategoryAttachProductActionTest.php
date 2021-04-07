<?php

declare(strict_types=1);

namespace Test\Functional\Category;

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
        $this->markTestIncomplete('Success');

        $id = CategoryFixture::$CATEGORY->getId()->getValue();

        $request = self::json('POST', '/v1/categories/attach/products');

        $body = [
            'id' => $id,
            'products' => [
                '',
                ''
            ]
        ];

        $request = $request->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'message' => 'Category already set!'
        ];

        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailNotFoundCategory(): void
    {
        $this->markTestIncomplete('Not found category');

        $undefinedId = '09fd5250-4bb7-48d0-87b5-dc3a75a54716';

        $request = self::json('POST', '/v1/categories/attach/products');

        $body = [
            'id' => $undefinedId,
            'products' => [
                '',
                ''
            ]
        ];
    }

    public function testFailNotFoundProduct(): void
    {
        $this->markTestIncomplete('Not found product');

        $id = CategoryFixture::$CATEGORY->getId()->getValue();

        $request = self::json('POST', '/v1/categories/attach/products');

        $body = [
            'id' => $id,
            'products' => [
                '',
                ''
            ]
        ];
    }

    public function testFailHaveCategoryId(): void
    {
        $this->markTestIncomplete('Have category ID');

        $id = CategoryFixture::$CATEGORY->getId()->getValue();

        $request = self::json('POST', '/v1/categories/attach/products');

        $body = [
            'id' => $id,
            'products' => [
                '',
                ''
            ]
        ];
    }
}