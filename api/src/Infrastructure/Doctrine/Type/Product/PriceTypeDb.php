<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Product;

use App\Model\Product\Type\PriceType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\FloatType;

class PriceTypeDb extends FloatType
{
    public const NAME = 'product_price_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): float
    {
        return $value instanceof PriceType ? $value->getValue() : (float)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PriceType
    {
        return !empty($value) ? new PriceType((float)$value) : null;
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