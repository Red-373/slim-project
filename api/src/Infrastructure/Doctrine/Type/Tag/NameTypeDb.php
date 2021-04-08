<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Tag;

use App\Model\Tag\Type\NameTagType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class NameTypeDb extends StringType
{
    public const NAME = 'tag_name_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof NameTagType ? $value->getValue() : (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?NameTagType
    {
        return !empty($value) ? new NameTagType((string)$value) : null;
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
