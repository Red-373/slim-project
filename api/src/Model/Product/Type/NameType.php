<?php

declare(strict_types=1);

namespace App\Model\Product\Type;

use InvalidArgumentException;

class NameType
{
    private string $value;

    public function __construct(string $value)
    {
        /*if (!preg_match('/^[a-zA-Zа-яА-Яа]+$/u', $value)) {
            throw new InvalidArgumentException('The product name can have only letters and no have spaces.');
        }*/

        if (3 > mb_strlen($value)) {
            throw new InvalidArgumentException('The product name cannot be less 3 symbols');
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
