<?php

declare(strict_types=1);

namespace App\Model\Category\Type\Test;

use App\Model\Category\Type\NameType;
use App\Model\Type\UuidType;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Throwable;

class NameTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $nameTypeEn = new NameType($valueEn = 'Tea');
        $nameTypeRus = new NameType($valueRus = 'Чай');

        self::assertEquals($valueEn, $nameTypeEn->getValue());
        self::assertEquals($valueRus, $nameTypeRus->getValue());
    }

    public function testExceptionMessage(): void
    {
        try {
            new NameType('123');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The name can have only letters and no have spaces.');
        }
    }

    public function testException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameType('123');
    }

    public function testLengthExceptionMessage(): void
    {
        try {
            new NameType('on');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The name cannot be less 3 symbols');
        }
    }

    public function testLengthException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameType('on');
    }

    public function testIsEqualTo(): void
    {
        $nameType = new NameType($value = 'Tea');
        $nameType2 = new NameType($value2 = 'Coffee');

        self::assertTrue($nameType->isEqualTo(new NameType($value)));
        self::assertFalse($nameType->isEqualTo($nameType2));
    }
}
