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
        $id = CategoryFixture::$CATEGORY->getId()->getValue();

        $request = self::json('POST', '/v1/products/add');

        $body = [
            'category_id' => $id,
            'name' => 'Nokia C3',
            'price' => 199.99,
            'description' => 'Lalalalala lalal alal',
        ];

        $request = $request->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody());

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testFail()
    {
        $id = CategoryFixture::$CATEGORY->getId()->getValue() . 's';

        $request = self::json('POST', '/v1/products/add');

        $body = [
            'category_id' => $id,
            'name' => 'Nokia C3',
            'price' => 199.99,
            'description' => 'Lalalalala lalal alal',
        ];

        $request = $request->withParsedBody($body);
        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        self::assertTrue($data['exception'][0]['type'] === 'InvalidArgumentException');
        self::assertTrue($data['exception'][0]['message'] === 'Value is not valid uuid.');
        self::assertEquals(500, $response->getStatusCode());
    }
}