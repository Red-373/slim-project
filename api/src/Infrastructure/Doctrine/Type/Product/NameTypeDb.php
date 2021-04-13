<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Product;

use App\Model\Product\Type\NameProductType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class NameTypeDb extends StringType
{
    public const NAME = 'product_name_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof NameProductType ? $value->getValue() : (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?NameProductType
    {
        return !empty($value) ? new NameProductType((string)$value) : null;
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
