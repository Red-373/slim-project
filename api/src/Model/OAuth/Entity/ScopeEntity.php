<?php

declare(strict_types=1);

namespace App\Model\OAuth\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;

class ScopeEntity implements ScopeEntityInterface
{
    use EntityTrait, ScopeTrait;
}