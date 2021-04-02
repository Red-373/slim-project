<?php

declare(strict_types=1);

namespace App\Model\Product\Command\Add;

use App\Model\Category\Entity\Category;
use InvalidArgumentException;

class Command
{
    public string $name;
    public string $description;
    public float $price;
    public string $id;

    public function validate()
    {
        if (empty($this->id)) {
            throw new InvalidArgumentException('Value id could not be empty.');
        }

        if (empty($this->name)) {
            throw new InvalidArgumentException('Value name could not be empty.');
        }

        if (2 >= mb_strlen($this->name)) {
            throw new InvalidArgumentException('Name have more 2 symbols.');
        }

        if ($this->price <= 0) {
            throw new InvalidArgumentException('The price must be greater than zero.');
        }

        if (2 >= mb_strlen($this->name)) {
            throw new InvalidArgumentException('Description have more 2 symbols.');
        }
    }
}