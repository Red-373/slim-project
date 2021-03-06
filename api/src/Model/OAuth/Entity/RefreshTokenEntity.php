<?php

declare(strict_types=1);

namespace App\Model\OAuth\Entity;

use DateTime;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class RefreshTokenEntity
 * @package App\Model\OAuth\Entity
 * @ORM\Entity
 * @ORM\Table(name="oauth_refresh_tokens")
 */
class RefreshTokenEntity implements RefreshTokenEntityInterface
{
    use RefreshTokenTrait;
    use EntityTrait;

    /**
     * @ORM\Column(type="string", length=80)
     * @ORM\Id
     */
    protected $identifier;

    /**
     * @var AccessTokenEntityInterface
     * @ORM\ManyToOne(targetEntity="AccessTokenEntity")
     * @ORM\JoinColumn(name="access_token_identifier", referencedColumnName="identifier", nullable=false, onDelete="CASCADE")
     */
    protected $accessToken;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="expiry_date_time")
     */
    protected $expiryDateTime;
}
