<?php

declare(strict_types=1);

namespace Test\Functional\User;

use Test\Functional\WebTestCase;

class LogoutAllActionTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testSuccess(): void
    {
        $response = $this->app()->handle(self::json('POST', '/v1/user/logout/all', [], self::$HEADERS));
        $data = json_decode((string)$response->getBody(), true);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals([], $data);
    }
}