<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\User;

use App\Model\User\Type\EmailType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;


class EmailTypeDb extends StringType
{
    public const NAME = 'user_email';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof EmailType ? $value->getValue() : (!empty($value) ? (string)$value : null);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?EmailType
    {
        return !empty($value) ? new EmailType((string)$value) : null;
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