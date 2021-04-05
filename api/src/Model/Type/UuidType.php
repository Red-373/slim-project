<?php

declare(strict_types=1);

namespace App\Model\Type;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class UuidType
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::uuid($value,'Value is not valid uuid.');
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

    public function __toString(): string
    {
        return $this->getValue();
    }
}
