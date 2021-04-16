<?php

declare(strict_types=1);

namespace App\Model\User\Command\Logout;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=80)
     */
    public string $jwt;
}