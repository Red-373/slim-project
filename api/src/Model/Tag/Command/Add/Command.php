<?php

declare(strict_types=1);

namespace App\Model\Tag\Command\Add;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    public string $name;

    /**
     * @Assert\Uuid
     */
    public string $productId;
}
