<?php

declare(strict_types=1);

namespace App\Model\User\Type;

use Webmozart\Assert\Assert;

class EmailType
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::email($value,'Invalid email');

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