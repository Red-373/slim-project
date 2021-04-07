<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Update;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     * @Assert\Uuid()
     */
    public string $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     */
    public string $name;
}
