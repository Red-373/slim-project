<?php
declare(strict_types=1);

namespace App\Model\Product\Type\Test;

use App\Model\Product\Type\DescriptionType;
use Monolog\Test\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class DescriptionTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $descriptionType = new DescriptionType($value = 'Valid description');
        self::assertEquals($value, $descriptionType->getValue());
    }

    public function testLengthExceptionMessage(): void
    {
        try {
            new DescriptionType('in');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The description cannot be less 3 symbols.');
        }
    }

    public function testLengthException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DescriptionType('in');
    }

    public function testIsEqualTo(): void
    {
        $descriptionType = new DescriptionType($value = 'First description');
        $descriptionTypeSec = new DescriptionType('Second description');

        self::assertTrue($descriptionType->isEqualTo(new DescriptionType($value)));
        self::assertFalse($descriptionType->isEqualTo($descriptionTypeSec));
    }
}