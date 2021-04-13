<?php

declare(strict_types=1);

namespace App\Model\Tag\Type\Test;

use App\Model\Tag\Type\NameTagType;
use Monolog\Test\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class NameTagTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $nameType = new NameTagType($value = 'ValidName');
        self::assertEquals($value, $nameType->getValue());
    }

    public function testFailRegexExceptionMessage(): void
    {
        try {
            new NameTagType('Invalid name');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The product name can have only letters and no have spaces.');
        }
    }

    public function testFailRegexException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameTagType('Invalid name');
    }

    public function testLengthExceptionMessage(): void
    {
        try {
            new NameTagType('in');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The product name cannot be less 3 symbols.');
        }
    }

    public function testLengthException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameTagType('in');
    }

    public function testIsEqualTo(): void
    {
        $nameType = new NameTagType($value = 'FirstDescription');
        $nameTypeSec = new NameTagType('SecondDescription');

        self::assertTrue($nameType->isEqualTo(new NameTagType($value)));
        self::assertFalse($nameType->isEqualTo($nameTypeSec));
    }
}
