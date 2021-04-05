<?php

declare(strict_types=1);

namespace App\Model\Category\Type;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class NameType
{
    private string $value;

    public function __construct(string $value)
    {
        //Assert::regex($value, '/^[a-zA-Zа-яА-Яа]+$/u', 'The name can have only letters and no have spaces.');
        //Assert::minLength(3, 'The name cannot be less 3 symbols.');

        if (!preg_match('/^[a-zA-Zа-яА-Яа]+$/u', $value)) {
            throw new InvalidArgumentException('The name can have only letters and no have spaces.');
        }

        if (3 > mb_strlen($value)) {
            throw new InvalidArgumentException('The name cannot be less 3 symbols');
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
