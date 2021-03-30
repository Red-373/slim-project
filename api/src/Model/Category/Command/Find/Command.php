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
            throw new InvalidArgumentException('Value name could not be empty');
        }

        if (2 >= mb_strlen($this->name)) {
            throw new InvalidArgumentException('Name have more 2 symbols');
        }
    }
}