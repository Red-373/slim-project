<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Category;

use InvalidArgumentException;

class Command
{
    public string $id;

    public function validate(): void
    {
        if (empty($this->id)) {
            throw new InvalidArgumentException('Value id could not be empty.');
        }
    }
}
