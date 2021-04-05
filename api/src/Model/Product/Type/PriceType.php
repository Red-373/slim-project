<?php

declare(strict_types=1);

namespace App\Model\Product\Type;

use Webmozart\Assert\Assert;

class PriceType
{
    private float $value;

    public function __construct(float $value)
    {
        Assert::float($value, 'Price need be float.');
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function isEqualTo(self $another): bool
    {
        return $this->value === $another->getValue();
    }
}
