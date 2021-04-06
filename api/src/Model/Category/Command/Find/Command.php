<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Find;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=50)
     */
    public string $name;

    /*public function validate(): void
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException('Value name could not be empty.');
        }

        if (mb_strlen($this->name) < 2) {
            throw new InvalidArgumentException('The name must not be shorter than 2 characters.');
        }
    }*/
}
