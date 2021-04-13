<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Category;

use App\Model\Category\Type\NameCategoryType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class NameTypeDb extends StringType
{
    public const NAME = 'category_name_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof NameCategoryType ? $value->getValue() : (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?NameCategoryType
    {
        return !empty($value) ? new NameCategoryType((string)$value) : null;
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
