<?php

declare(strict_types=1);

namespace App\Model\Category\Type;

use InvalidArgumentException;

class NameType
{
    private string $value;

    public function __construct(string $value)
    {
        if (!preg_match('/^[a-zA-Zа-яА-Яа]+$/u', $value)) {
            throw new InvalidArgumentException('The name cannot contain numbers');
        }

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