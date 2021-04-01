<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Find;

use InvalidArgumentException;

class Command
{
    public string $name;

    public function validate(): void
    {
        if (empty($this->name)) {
            throw new InvalidArgumentException('Value name could not be empty.');
        }

        if (mb_strlen($this->name) < 2) {
            throw new InvalidArgumentException('The name must not be shorter than 2 characters.');
        }
    }
}