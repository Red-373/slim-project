<?php

declare(strict_types=1);

namespace App\Model\Product\Command\Add;

use InvalidArgumentException;

class Command
{
    public string $name;
    public string $description;
    public float $price;
    public string $categoryId;

    public function validate()
    {
        if (empty($this->categoryId)) {
            throw new InvalidArgumentException('Value id could not be empty.');
        }
        //uuid
        if (empty($this->name)) {
            throw new InvalidArgumentException('Value name could not be empty.');
        }

        if (2 >= mb_strlen($this->name)) {
            throw new InvalidArgumentException('Name have more 2 symbols.');
        }

        if ($this->price <= 0) {
            throw new InvalidArgumentException('The price must be greater than zero.');
        }
        //isFloat
        if (2 >= mb_strlen($this->name)) {
            throw new InvalidArgumentException('Description have more 2 symbols.');
        }
        /// https://symfony.com/doc/current/components/validator/resources.html id через это
    }
}
