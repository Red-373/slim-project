<?php

declare(strict_types=1);

namespace Test\Functional\Category;

use App\Model\Type\UuidType;
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
        $body = [
            'id' => CategoryFixture::$CATEGORY->getId()->getValue(),
            'name' => 'NewName',
        ];

        $request = self::json('PUT', '/v1/categories/update', $body, CategoryFixture::getAuthHeader());
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testGuest()
    {
        $body = [
            'id' => CategoryFixture::$CATEGORY->getId()->getValue(),
            'name' => 'NewName',
        ];

        $request = self::json('PUT', '/v1/categories/update', $body);
        $response = $this->app()->handle($request);

        self::assertEquals(401, $response->getStatusCode());
    }

    public function testFailSameName(): void
    {
        $body = [
            'id' => CategoryFixture::$CATEGORY->getId()->getValue(),
            'name' => CategoryFixture::$CATEGORY->getName()->getValue(),
        ];

        $request = self::json('PUT', '/v1/categories/update', $body, CategoryFixture::getAuthHeader());
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
        $body = [
            'id' => '',
            'name' => '',
        ];

        $request = self::json('PUT', '/v1/categories/update', $body, CategoryFixture::getAuthHeader());
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
        $body = [
            'id' => 'invaliduuid',
            'name' => 'Name',
        ];

        $request = self::json('PUT', '/v1/categories/update', $body, CategoryFixture::getAuthHeader());
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
        $body = [
            'id' => CategoryFixture::$CATEGORY->getId()->getValue(),
            'name' => 'Na',
        ];

        $request = self::json('PUT', '/v1/categories/update', $body, CategoryFixture::getAuthHeader());
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

    public function testFailNotFoundCategory(): void
    {
        $id = UuidType::generate()->getValue();
        $body = [
            'id' => $id,
            'name' => 'Name',
        ];

        $request = self::json('PUT', '/v1/categories/update', $body, CategoryFixture::getAuthHeader());
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $message = [
            'message' => 'Not found category for id = ' . $id . '.'
        ];
        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($message, $data);
    }
}