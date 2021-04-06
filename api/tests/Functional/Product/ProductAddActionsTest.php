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
        $id = CategoryFixture::$CATEGORY->getId()->getValue();

        $request = self::json('POST', '/v1/products/add');

        $body = [
            'category_id' => $id,
            'name' => 'Nokia',
            'price' => 199,
            'description' => 'Lalalalala lalal alal',
        ];

        $request = $request->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody());

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testFailNotFoundCategory()
    {
        $id = 'b4eb097b-1b32-4121-bccb-41bdbb240492';

        $request = self::json('POST', '/v1/products/add');

        $body = [
            'category_id' => $id,
            'name' => 'Nokia',
            'price' => 199,
            'description' => 'Lalalalala lalal alal',
        ];

        $request = $request->withParsedBody($body);
        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        self::assertTrue($data['message'] === 'Not found category.');
        self::assertEquals(409, $response->getStatusCode());
    }

    public function testFailIncorrectValues()
    {
        $id = 'a0cd6990-10bf-43cd-a5f6-c037c4b969eeE';

        $request = self::json('POST', '/v1/products/add');

        $body = [
            'category_id' => $id,
            'name' => '',
            'price' => -2.5,
            'description' => '',
        ];

        $request = $request->withParsedBody($body);
        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        self::assertTrue($data['errors']['categoryId'] === 'This is not a valid UUID.');
        self::assertTrue($data['errors']['name'] === 'This value is too short. It should have 3 characters or more.');
        self::assertTrue($data['errors']['description'] === 'This value is too short. It should have 3 characters or more.');
        self::assertTrue($data['errors']['price'] === 'This value should be positive.');
    }
}