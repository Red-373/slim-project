<?php

declare(strict_types=1);

namespace Test\Functional\Category;

use Test\Fixture\Category\CategoryFixture;
use Test\Functional\WebTestCase;

class CategoryActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([CategoryFixture::class]);
    }

    public function testSuccess(): void
    {
        $id = CategoryFixture::$CATEGORY->getId()->getValue();
        $name = CategoryFixture::$CATEGORY->getName()->getValue();

        $response = $this->app()->handle(self::json('GET', '/v1/categories?id=' . $id, [], CategoryFixture::getAuthHeader()));

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals($name, $data['name']);
        self::assertEquals($id, $data['id']);
    }

    public function testGuest()
    {
        $id = CategoryFixture::$CATEGORY->getId()->getValue();

        $response = $this->app()->handle(self::json('GET', '/v1/categories?id=' . $id));

        self::assertEquals(401, $response->getStatusCode());
    }

    public function testFailEmptyId(): void
    {
        $response = $this->app()->handle(self::json('GET', '/v1/categories?id=', [], CategoryFixture::getAuthHeader()));

        $data = json_decode($response->getBody()->getContents(), true);

        $errors = [
            'errors' => [
                'id' => 'This value should not be blank.'
            ]
        ];

        self::assertEquals($errors, $data);
    }

    public function testFailIncorrectId(): void
    {
        $response = $this->app()->handle(self::json('GET', '/v1/categories?id=IncorrectId', [], CategoryFixture::getAuthHeader()));

        $data = json_decode($response->getBody()->getContents(), true);

        $errors = [
            'errors' => [
                'id' => 'This is not a valid UUID.'
            ]
        ];

        self::assertEquals($errors, $data);
    }
}