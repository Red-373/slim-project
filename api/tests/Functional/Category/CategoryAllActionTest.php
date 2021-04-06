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
        $response = $this->app()->handle(self::json('GET', '/v1/categories/all'));

        $data = json_decode($response->getBody()->getContents(), true);

        $categories = [
            [
                "id" => "642abaa5-481e-4a60-ac3e-b7665f5b53a0",
                "name" => "Smartphone",
                "products" => []
            ],
            [
                "id" => "642abaa5-481e-4a60-ac3e-b7665f5b53a4",
                "name" => "Phones",
                "products" => []
            ]
        ];

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals($categories, $data);
    }
}