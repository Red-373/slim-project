<?php

declare(strict_types=1);

namespace Test\Functional\Category;

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
        $id = CategoryFixture::CORRECT_UUID;

        $request = self::json('POST', '/v1/products/add');

        $body = [
            'category_id' => $id,
            'name' => 'Nokia C3',
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
        $id = CategoryFixture::UNDEFINED_UUID;

        $request = self::json('POST', '/v1/products/add');

        $body = [
            'category_id' => $id,
            'name' => 'Nokia C3',
            'price' => 199,
            'description' => 'Lalalalala lalal alal',
        ];

        $request = $request->withParsedBody($body);
        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        self::assertTrue($data['exception'][0]['type'] === 'InvalidArgumentException');
        self::assertTrue($data['exception'][0]['message'] === 'Not found category.');
        self::assertEquals(500, $response->getStatusCode());
    }

    public function testFailIncorrectValues()
    {
        $id = CategoryFixture::INCORRECT_UUID;

        $request = self::json('POST', '/v1/products/add');

        $body = [
            'category_id' => $id,
            'name' => '',
            'price' => '',
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