<?php

declare(strict_types=1);

namespace App\Model\Type;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class UuidType
{
    private string $value;

    public function __construct(string $value)
    {
        if (!Uuid::isValid($value)) {
            throw new InvalidArgumentException('Value is not valid uuid.');
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function isEqualTo(self $another): bool
    {
        return $this->value === $another->getValue();
    }
}