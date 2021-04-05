<?php

declare(strict_types=1);

namespace App\Model\Product\Type;

use Webmozart\Assert\Assert;

class DescriptionType
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::minLength($value, 3, 'The description cannot be less 3 symbols.');

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqualTo(self $another): bool
    {
        return $this->value === $another->getValue();
    }
}
