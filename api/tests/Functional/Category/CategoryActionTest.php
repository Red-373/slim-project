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

    public function testSuccess()
    {
        $id = CategoryFixture::$CATEGORY->getId()->getValue();
        $name = CategoryFixture::$CATEGORY->getName()->getValue();

        $response = $this->app()->handle(self::json('GET', '/v1/categories?id=' . $id));

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals($name, $data['name']);
        self::assertEquals($id, $data['id']);
    }

    public function testEmptyId()
    {
        $id = CategoryFixture::$CATEGORY->getId()->getValue();
        $name = CategoryFixture::$CATEGORY->getName()->getValue();

        $response = $this->app()->handle(self::json('GET', '/v1/categories?id=' . $id));

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals($name, $data['name']);
        self::assertEquals($id, $data['id']);
    }
}