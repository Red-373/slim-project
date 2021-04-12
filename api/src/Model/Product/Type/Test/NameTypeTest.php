<?php
declare(strict_types=1);

namespace App\Model\Product\Type\Test;

use App\Model\Product\Type\NameType;
use Monolog\Test\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class NameTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $nameType = new NameType($value = 'ValidName');
        self::assertEquals($value, $nameType->getValue());
    }

    public function testFailRegexExceptionMessage(): void
    {
        try {
            new NameType('Invalid name');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The product name can have only letters and no have spaces.');
        }
    }

    public function testFailRegexException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameType('Invalid name');
    }

    public function testLengthExceptionMessage(): void
    {
        try {
            new NameType('in');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The product name cannot be less 3 symbols.');
        }
    }

    public function testLengthException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NameType('in');
    }

    public function testIsEqualTo(): void
    {
        $nameType = new NameType($value = 'FirstDescription');
        $nameTypeSec = new NameType('SecondDescription');

        self::assertTrue($nameType->isEqualTo(new NameType($value)));
        self::assertFalse($nameType->isEqualTo($nameTypeSec));
    }
}