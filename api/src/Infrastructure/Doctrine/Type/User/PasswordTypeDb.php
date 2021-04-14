<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\User;

use App\Model\User\Type\PasswordType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class PasswordTypeDb extends StringType
{
    public const NAME = 'user_password';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof PasswordType ? $value->getValue() : (!empty($value) ? (string)$value : null);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PasswordType
    {
        return !empty($value) ? new PasswordType((string)$value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
