<?php

declare(strict_types=1);

namespace App\Model\Category\Type\Test;

use App\Model\Category\Type\NameCategoryType;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class NameTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $nameTypeEn = new NameCategoryType($valueEn = 'Tea');
        $nameTypeRus = new NameCategoryType($valueRus = 'Чай');

        self::assertEquals($valueEn, $nameTypeEn->getValue());
        self::assertEquals($valueRus, $nameTypeRus->getValue());
    }

    public function testExceptionMessage(): void
    {
        try {
            new NameCategoryType('123');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The name can have only letters and no have spaces.');
        }
    }

    public function testException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameCategoryType('123');
    }

    public function testLengthExceptionMessage(): void
    {
        try {
            new NameCategoryType('on');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The name cannot be less 3 symbols.');
        }
    }

    public function testLengthException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameCategoryType('on');
    }

    public function testIsEqualTo(): void
    {
        $nameType = new NameCategoryType($value = 'Tea');
        $nameType2 = new NameCategoryType('Coffee');

        self::assertTrue($nameType->isEqualTo(new NameCategoryType($value)));
        self::assertFalse($nameType->isEqualTo($nameType2));
    }
}
