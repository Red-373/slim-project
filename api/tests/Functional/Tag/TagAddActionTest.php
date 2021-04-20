<?php

declare(strict_types=1);

namespace Test\Functional\Tag;

use Test\Fixture\Tag\TagFixture;
use Test\Functional\WebTestCase;

class TagAddActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([TagFixture::class]);
    }

    public function testSuccess()
    {
        $body = [
            'name' => 'UniqueName',
        ];


        $response = $this->app()->handle(self::json('POST', '/v1/tags/add', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testSuccessWithProduct()
    {
        $productId = TagFixture::$PRODUCT->getId()->getValue();
        $body = [
            'name' => 'UniqueName',
            'product' => $productId
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/tags/add', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testFailTagAlreadySet(): void
    {
        $name = TagFixture::$TAG->getName()->getValue();
        $body = [
            'name' => $name,
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/tags/add', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'message' => 'Tag already set!'
        ];
        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailLengthName(): void
    {
        $body = [
            'name' => 'na',
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/tags/add', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'name' => 'This value is too short. It should have 3 characters or more.'
            ]
        ];
        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailIncorrectProductId(): void
    {
        $body = [
            'name' => 'UniqueName',
            'product' => 'NotValidUUid'
        ];

        $response = $this->app()->handle(self::json('POST', '/v1/tags/add', $body, self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'productId' => 'This is not a valid UUID.'
            ]
        ];
        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }
}