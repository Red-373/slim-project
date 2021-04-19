<?php

declare(strict_types=1);

namespace Test\Functional;


class OAuthActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess(): void
    {
        $postData = [
            'grant_type' => 'password',
            'username' => 'oauth@example.com',
            'password' => 'password',
            'client_id' => 'app',
            'client_secret' => ''
        ];
        $response = $this->app()->handle(self::json('POST', '/oauth', $postData));
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());

        self::assertArrayHasKey('token_type', $data);
        self::assertNotEmpty($data['expires_in']);

        self::assertArrayHasKey('expires_in', $data);
        self::assertNotEmpty($data['expires_in']);

        self::assertArrayHasKey('access_token', $data);
        self::assertNotEmpty($data['access_token']);

        self::assertArrayHasKey('refresh_token', $data);
        self::assertNotEmpty($data['refresh_token']);
    }
}