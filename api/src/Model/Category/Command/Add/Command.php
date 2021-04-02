<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Add;

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

        if (!preg_match('/^[a-zA-Zа-яА-Яа]+$/u', $this->name)) {
            throw new InvalidArgumentException('The name cannot contain numbers');
        }
    }
}
