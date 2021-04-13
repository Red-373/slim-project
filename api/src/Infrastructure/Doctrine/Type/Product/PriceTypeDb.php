<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\Product;

use App\Model\Product\Type\PriceProductType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\FloatType;

class PriceTypeDb extends FloatType
{
    public const NAME = 'product_price_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): float
    {
        return $value instanceof PriceProductType ? $value->getValue() : (float)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PriceProductType
    {
        return !empty($value) ? new PriceProductType((float)$value) : null;
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
