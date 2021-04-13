<?php

declare(strict_types=1);

namespace App\Model\Type\Test;

use App\Model\Category\Type\NameCategoryType;
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

    public function testExceptionMessage(): void
    {
        try {
            new UuidType('123');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'Value is not valid uuid.');
        }
    }

    public function testException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameCategoryType('123');
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
