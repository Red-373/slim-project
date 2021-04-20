<?php

declare(strict_types=1);

namespace Test\Functional\Product;

use Test\Fixture\Category\CategoryFixture;
use Test\Functional\WebTestCase;

class ProductAddActionsTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([CategoryFixture::class]);
    }

    public function testSuccess()
    {
        $categoryId = CategoryFixture::$CATEGORY->getId()->getValue();
        $body = [
            'category_id' => $categoryId,
            'name' => 'UniqueName',
            'price' => 199.25,
            'description' => 'Lalalalala lalal alal',
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/products/add', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testFailNotFoundCategory()
    {
        $id = 'b4eb097b-1b32-4121-bccb-41bdbb240492';
        $body = [
            'category_id' => $id,
            'name' => 'Nokia',
            'price' => 199,
            'description' => 'Lalalalala lalal alal',
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/products/add', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        self::assertTrue($data['message'] === 'Not found category.');
        self::assertEquals(409, $response->getStatusCode());
    }

    public function testFailIncorrectValues()
    {
        $id = 'a0cd6990-10bf-43cd-a5f6-c037c4b969eeE';
        $body = [
            'category_id' => $id,
            'name' => '',
            'price' => -2.5,
            'description' => '',
        ];


        $response = $this->app()->handle(self::json('POST', '/v1/products/add', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        self::assertTrue($data['errors']['categoryId'] === 'This is not a valid UUID.');
        self::assertTrue($data['errors']['name'] === 'This value is too short. It should have 3 characters or more.');
        self::assertTrue($data['errors']['description'] === 'This value is too short. It should have 3 characters or more.');
        self::assertTrue($data['errors']['price'] === 'This value should be positive.');
    }
}