<?php

declare(strict_types=1);

namespace Test\Functional\Category;

use Test\Fixture\Category\CategoryFixture;
use Test\Functional\WebTestCase;

class CategoryAllActionTest extends WebTestCase
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

        $response = $this->app()->handle(self::json('GET', '/v1/categories/all'));

        $data = json_decode($response->getBody()->getContents(), true);

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
                ]
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
}