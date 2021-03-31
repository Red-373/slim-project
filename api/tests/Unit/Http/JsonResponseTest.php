<?php

declare(strict_types=1);

namespace Test\Unit\Http;

use App\Http\JsonResponse;
use PHPUnit\Framework\TestCase;
use StdClass;

/**
 * Class JsonResponseTest
 * @package Test\Unit\Http
 * @covers \App\Http\JsonResponse
 */
class JsonResponseTest extends TestCase
{
    public function testInt(): void
    {
        $response = new JsonResponse(12);

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals('12', $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testIntWithCode(): void
    {
        $response = new JsonResponse(12, 201);

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals('12', $response->getBody()->getContents());
        self::assertEquals(201, $response->getStatusCode());
    }

    /**
     * @dataProvider getCases
     * @param $source
     * @param $expect
     * @throws \JsonException
     */
    public function testResponse($source, $expect): void
    {
        $response = new JsonResponse($source);

        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals($expect, $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return array<mixed>
     */
    public function getCases(): array
    {
        $object = new StdClass();
        $object->str = 'value';
        $object->int = 1;
        $object->none = null;

        $array = [
            'str' => 'value',
            'int' => 1,
            'none' => null
        ];

        return [
            'null' => [null, 'null'],
            'empty' => ['', '""'],
            'number' => [12, '12'],
            'string' => ['12', '"12"'],
            'object' => [$object, '{"str":"value","int":1,"none":null}'],
            'array' => [$array, '{"str":"value","int":1,"none":null}'],
        ];
    }
}