<?php

declare(strict_types=1);

namespace App\Model\User\Type;

use Webmozart\Assert\Assert;

class PasswordType
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::length($value, 8, 'Password length.');

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
