<?php

declare(strict_types=1);

namespace App\Model\OAuth\Entity;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AccessTokenEntity
 * @ORM\Entity
 * @ORM\Table(name="oauth_access_tokens")
 */
class AccessTokenEntity implements AccessTokenEntityInterface
{
    use AccessTokenTrait;
    use TokenEntityTrait;
    use EntityTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     * @ORM\Id
     */
    protected $identifier;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", name="expiry_date_time")
     */
    protected $expiryDateTime;

    /**
     * @var string
     * @ORM\Column(type="uuid_type", name="user_identifier")
     */
    protected $userIdentifier;

    /**
     * @var ClientEntityInterface
     * @ORM\Column(type="oauth_client")
     */
    protected $client;

    /**
     * @var ScopeEntityInterface
     * @ORM\Column(type="oauth_scopes")
     */
    protected $scopes = [];
}
