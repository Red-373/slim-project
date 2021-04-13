<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type\OAuth;

use App\Model\OAuth\Entity\ClientEntity;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ClientTypeDb extends StringType
{
    public const NAME = 'oauth_client';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value instanceof ClientEntity ? $value->getIdentifier() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ClientEntity
    {
        return !empty($value) ? new ClientEntity((string)$value) : null;
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