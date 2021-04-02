<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Model\Type\UuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UuidTypeDb extends GuidType
{
    public const NAME = 'uuid_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof UuidType ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?UuidType
    {
        return !empty($value) ? new UuidType((string)$value) : null;
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
