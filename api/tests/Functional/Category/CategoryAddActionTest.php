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
        $request = self::json('POST', '/v1/categories/add');

        $body = [
            'name' => 'Nokia',
        ];

        $request = $request->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody());

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testCategoryAlreadySet(): void
    {
        $request = self::json('POST', '/v1/categories/add');

        $name = CategoryFixture::$CATEGORY->getName()->getValue();

        $body = [
            'name' => $name,
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

    public function testFailRegexName(): void
    {
        $request = self::json('POST', '/v1/categories/add');

        $body = [
            'name' => 'invalidName123',
        ];

        $request = $request->withParsedBody($body);

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
        $request = self::json('POST', '/v1/categories/add');

        $body = [
            'name' => 'le',
        ];

        $request = $request->withParsedBody($body);

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