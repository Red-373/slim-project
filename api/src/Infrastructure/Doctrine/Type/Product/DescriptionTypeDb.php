<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Product;

use App\Model\Product\Type\DescriptionType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class DescriptionTypeDb extends StringType
{
    public const NAME = 'product_description_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof DescriptionType ? $value->getValue() : (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DescriptionType
    {
        return !empty($value) ? new DescriptionType((string)$value) : null;
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