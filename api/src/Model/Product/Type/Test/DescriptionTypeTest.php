<?php
declare(strict_types=1);

namespace App\Model\Product\Type\Test;

use App\Model\Product\Type\DescriptionProductType;
use Monolog\Test\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class DescriptionTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $descriptionType = new DescriptionProductType($value = 'Valid description');
        self::assertEquals($value, $descriptionType->getValue());
    }

    public function testLengthExceptionMessage(): void
    {
        try {
            new DescriptionProductType('in');
        } catch (InvalidArgumentException $e) {
            self::assertTrue($e->getMessage() === 'The description cannot be less 3 symbols.');
        }
    }

    public function testLengthException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new DescriptionProductType('in');
    }

    public function testIsEqualTo(): void
    {
        $descriptionType = new DescriptionProductType($value = 'First description');
        $descriptionTypeSec = new DescriptionProductType('Second description');

        self::assertTrue($descriptionType->isEqualTo(new DescriptionProductType($value)));
        self::assertFalse($descriptionType->isEqualTo($descriptionTypeSec));
    }
}