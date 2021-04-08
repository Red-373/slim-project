<?php

declare(strict_types=1);

namespace Test\Functional\Tag;

use Test\Fixture\Tag\TagFixture;
use Test\Functional\WebTestCase;

class TagActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([TagFixture::class]);
    }

    public function testSuccess()
    {
        $tagId = TagFixture::$TAG->getId()->getValue();

        $queryParams = [
            'id' => $tagId,
        ];
        $request = self::json('GET', '/v1/tags')->withQueryParams($queryParams);

        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $tags = [
            'id' => $tagId,
            'products' => []
        ];

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals($tags, $data);
    }

    public function testFailEmptyId(): void
    {
        $queryParams = [
            'id' => '',
        ];
        $request = self::json('GET', '/v1/tags')->withQueryParams($queryParams);

        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This value should not be blank.'
            ]
        ];

        self::assertEquals($errors, $data);
    }

    public function testFailIncorrectId(): void
    {
        $queryParams = [
            'id' => 'incorrectUuid',
        ];
        $request = self::json('GET', '/v1/tags')->withQueryParams($queryParams);

        $response = $this->app()->handle($request);
        $data = json_decode((string)$response->getBody(), true);

        $errors = [
            'errors' => [
                'id' => 'This is not a valid UUID.'
            ]
        ];

        self::assertEquals($errors, $data);
    }
}