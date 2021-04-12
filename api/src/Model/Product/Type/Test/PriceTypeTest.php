<?php
declare(strict_types=1);

namespace App\Model\Product\Type\Test;
use App\Model\Product\Type\PriceType;
use Monolog\Test\TestCase;

class PriceTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $descriptionType = new PriceType($value = 1.99);
        self::assertEquals($value, $descriptionType->getValue());
    }

    public function testIsEqualTo(): void
    {
        $priceType = new PriceType($value = 1.99);
        $priceTypeSec = new PriceType(2.55);

        self::assertTrue($priceType->isEqualTo(new PriceType($value)));
        self::assertFalse($priceType->isEqualTo($priceTypeSec));
    }
}