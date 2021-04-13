<?php

declare(strict_types=1);

namespace App\Model\Product\Type\Test;

use App\Model\Product\Type\PriceProductType;
use Monolog\Test\TestCase;

class PriceTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $descriptionType = new PriceProductType($value = 1.99);
        self::assertEquals($value, $descriptionType->getValue());
    }

    public function testIsEqualTo(): void
    {
        $priceType = new PriceProductType($value = 1.99);
        $priceTypeSec = new PriceProductType(2.55);

        self::assertTrue($priceType->isEqualTo(new PriceProductType($value)));
        self::assertFalse($priceType->isEqualTo($priceTypeSec));
    }
}
