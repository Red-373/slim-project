<?php

declare(strict_types=1);

namespace Test\Functional\Category;

use Test\Fixture\Category\CategoryFixture;
use Test\Functional\WebTestCase;

class CategoryAddActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([CategoryFixture::class]);
    }

    public function testSuccess(): void
    {
        $body = [
            'name' => 'UniqueName',
        ];

        $request = self::json('POST', '/v1/categories/add', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testGuest()
    {
        $body = [
            'name' => 'UniqueName',
        ];

        $request = self::json('POST', '/v1/categories/add', $body);
        $response = $this->app()->handle($request);

        self::assertEquals(401, $response->getStatusCode());
    }

    public function testFailCategoryAlreadySet(): void
    {
        $name = CategoryFixture::$CATEGORY->getName()->getValue();
        $body = [
            'name' => $name,
        ];

        $request = self::json('POST', '/v1/categories/add', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'message' => 'Category already set!'
        ];

        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailRegexName(): void
    {
        $body = [
            'name' => 'invalidName123',
        ];

        $request = self::json('POST', '/v1/categories/add', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $error = [
            'errors' => [
                'name' => 'The name cannot contain numbers.'
            ]
        ];

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($error, $data);
    }

    public function testFailLengthName(): void
    {
        $body = [
            'name' => 'le',
        ];

        $request = self::json('POST', '/v1/categories/add', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $error = [
            'errors' => [
                'name' => 'This value is too short. It should have 3 characters or more.'
            ]
        ];

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($error, $data);
    }
}