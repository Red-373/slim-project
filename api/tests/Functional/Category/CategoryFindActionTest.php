<?php

declare(strict_types=1);

namespace Test\Functional\Category;

use Test\Fixture\Category\CategoryFixture;
use Test\Functional\WebTestCase;

class CategoryFindActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([CategoryFixture::class]);
    }

    public function testSuccess(): void
    {
        $category = CategoryFixture::$CATEGORY;
        $secondCategory = CategoryFixture::$SECOND_CATEGORY;
        $product = CategoryFixture::$PRODUCT;

        $request = self::json('GET', '/v1/categories/find?name=' . $category->getName()->getValue(), [], CategoryFixture::getAuthHeader());
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $categories = [
            [
                "id" => $category->getId()->getValue(),
                "name" => $category->getName()->getValue(),
                "products" => [
                    [
                        'name' => $product->getName()->getValue(),
                        'price' => $product->getPrice()->getValue(),
                        'description' => $product->getDescription()->getValue(),
                        'id' => $product->getId()->getValue(),
                    ]
                ],
            ],
            [
                "id" => $secondCategory->getId()->getValue(),
                "name" => $secondCategory->getName()->getValue(),
                "products" => []
            ]
        ];
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals($categories, $data);
    }

    public function testGuest(): void
    {
        $category = CategoryFixture::$CATEGORY;

        $request = self::json('GET', '/v1/categories/find?name=' . $category->getName()->getValue());
        $response = $this->app()->handle($request);

        self::assertEquals(401, $response->getStatusCode());
    }

    public function testFailUndefinedName(): void
    {
        $request = self::json('GET', '/v1/categories/find?name=notfound', [], CategoryFixture::getAuthHeader());
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals([], $data);
    }

    public function testFailEmptyName(): void
    {
        $request = self::json('GET', '/v1/categories/find?name=', [], CategoryFixture::getAuthHeader());
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'name' => 'This value is too short. It should have 3 characters or more.'
            ]
        ];
        self::assertEquals($errors, $data);
    }

    public function testFailLengthName(): void
    {
        $request = self::json('GET', '/v1/categories/find?name=', [], CategoryFixture::getAuthHeader());
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'name' => 'This value is too short. It should have 3 characters or more.'
            ]
        ];
        self::assertEquals($errors, $data);
    }
}