<?php

declare(strict_types=1);

namespace Test\Functional\Category;

use Test\Fixture\Category\CategoryFixture;
use Test\Functional\WebTestCase;
use Webmozart\Assert\InvalidArgumentException;

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

        $response = $this->app()->handle(self::json('GET', '/v1/categories?id=' . $id));

        $data = json_decode($response->getBody()->getContents(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals($name, $data['name']);
        self::assertEquals($id, $data['id']);
    }

    public function testEmptyId(): void
    {
        $response = $this->app()->handle(self::json('GET', '/v1/categories?id='));

        $data = json_decode($response->getBody()->getContents(), true);

        $errors = [
            'errors' => [
                'id' => 'This value should not be blank.'
            ]
        ];

        self::assertEquals($errors, $data);
    }

    public function testIncorrectId(): void
    {
        $response = $this->app()->handle(self::json('GET', '/v1/categories?id=IncorrectId'));

        $data = json_decode($response->getBody()->getContents(), true);

        $errors = [
            'errors' => [
                'id' => 'This is not a valid UUID.'
            ]
        ];

        self::assertEquals($errors, $data);
    }
}