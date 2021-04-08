<?php

declare(strict_types=1);

namespace App\Model\Tag\Command\Tag;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    public string $id;
}