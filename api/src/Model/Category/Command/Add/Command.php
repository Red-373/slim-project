<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Add;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(min=3)
     * @Assert\Regex("/^[a-zA-Zа-яА-Яа]+$/u", message = "The name cannot contain numbers.")
     */
    public string $name;
}
