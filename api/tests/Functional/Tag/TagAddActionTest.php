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

        $request = self::json('POST', '/v1/tags/add')
            ->withParsedBody($body);

        $response = $this->app()->handle($request);

        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }

    public function testSuccessWithProduct()
    {
        $body = [
            'name' => 'UniqueName',
            'product' => ''
        ];

        $request = self::json('POST', '/v1/tags/add')
            ->withParsedBody($body);

        $response = $this->app()->handle($request);

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
        $request = self::json('POST', '/v1/tags/add')->withParsedBody($body);
        $response = $this->app()->handle($request);
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
        $request = self::json('POST', '/v1/tags/add')->withParsedBody($body);
        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'name' => 'This value is too short. It should have 3 characters or more.'
            ]
        ];

        self::assertEquals(422, $response->getStatusCode());
        self::assertEquals($errors, $data);
    }
}