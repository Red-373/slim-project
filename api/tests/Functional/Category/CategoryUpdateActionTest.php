<?php

declare(strict_types=1);

namespace Test\Functional\Category;

use Test\Fixture\Category\CategoryFixture;
use Test\Functional\WebTestCase;

class CategoryUpdateActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([CategoryFixture::class]);
    }

    public function testSuccess(): void
    {
        $request = self::json('PUT', '/v1/categories/update');

        $body = [
            'id' => CategoryFixture::$CATEGORY->getId()->getValue(),
            'name' => 'NewName',
        ];

        $request = $request->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testFailSameName(): void
    {
        $request = self::json('PUT', '/v1/categories/update');

        $body = [
            'id' => CategoryFixture::$CATEGORY->getId()->getValue(),
            'name' => CategoryFixture::$CATEGORY->getName()->getValue(),
        ];

        $request = $request->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        $error = [
            'message' => 'Same name.'
        ];

        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($error, $data);
    }

    public function testFailBlankRequest(): void
    {
        $request = self::json('PUT', '/v1/categories/update');

        $body = [
            'id' => '',
            'name' => '',
        ];

        $request = $request->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        $error = [
            'errors' => [
                'id' => 'This value should not be blank.',
                'name' => 'This value is too short. It should have 3 characters or more.'
            ]
        ];

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($error, $data);
    }

    public function testFailInvalidUuid(): void
    {
        $request = self::json('PUT', '/v1/categories/update');

        $body = [
            'id' => 'invaliduuid',
            'name' => 'Name',
        ];

        $request = $request->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        $error = [
            'errors' => [
                'id' => 'This is not a valid UUID.'
            ]
        ];

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($error, $data);
    }

    public function testFailNameMinLength(): void
    {
        $request = self::json('PUT', '/v1/categories/update');

        $body = [
            'id' => CategoryFixture::$CATEGORY->getId()->getValue(),
            'name' => 'Na',
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

    // TODO: Make test for Category Not found Exc
}