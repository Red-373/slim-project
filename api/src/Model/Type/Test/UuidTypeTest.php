<?php

declare(strict_types=1);

namespace App\Model\Type\Test;

use App\Model\Type\UuidType;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UuidTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $uuid = Uuid::uuid4();

        $uuidType = new UuidType($value = $uuid->toString());

        self::assertEquals($value, $uuidType->getValue());
    }

    public function testFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value is not valid uuid.');
        new UuidType('str');
    }

    public function testIsEqualTo(): void
    {
        $uuid = Uuid::uuid4();

        $uuidType = new UuidType($value = $uuid->toString());

        self::assertTrue($uuidType->isEqualTo(new UuidType($value)));
        self::assertFalse($uuidType->isEqualTo(UuidType::generate()));
    }

    public function testGenerate(): void
    {
        $uuid = UuidType::generate();

        self::assertTrue($uuid instanceof UuidType);
        self::assertTrue(Uuid::isValid($uuid->getValue()));
    }
}