<?php

declare(strict_types=1);

namespace Test\Functional\Category;

use App\Model\Type\UuidType;
use Test\Fixture\Category\CategoryFixture;
use Test\Functional\WebTestCase;

class CategoryDeleteActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([CategoryFixture::class]);
    }

    public function testSuccess(): void
    {
        $category = CategoryFixture::$CATEGORY;
        $body = [
            'id' => $category->getId()->getValue(),
        ];

        $request = self::json('DELETE', '/v1/categories/delete', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testGuest(): void
    {
        $category = CategoryFixture::$CATEGORY;
        $body = [
            'id' => $category->getId()->getValue(),
        ];

        $request = self::json('DELETE', '/v1/categories/delete', $body);
        $response = $this->app()->handle($request);

        self::assertEquals(401, $response->getStatusCode());
    }

    public function testFailBlankRequest(): void
    {
        $body = [
            'id' => '',
        ];

        $request = self::json('DELETE', '/v1/categories/delete', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This value should not be blank.'
            ]
        ];
        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailInvalidRequest(): void
    {
        $body = [
            'id' => 'invalidUuid',
        ];

        $request = self::json('DELETE', '/v1/categories/delete', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This is not a valid UUID.'
            ]
        ];
        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }

    public function testFailNotFoundCategory(): void
    {
        $undefinedId = UuidType::generate()->getValue();
        $body = [
            'id' => $undefinedId,
        ];

        $request = self::json('DELETE', '/v1/categories/delete', $body, self::$HEADERS);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'message' => 'Not found category id = ' . $undefinedId . '.'
        ];
        self::assertEquals(409, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }
}