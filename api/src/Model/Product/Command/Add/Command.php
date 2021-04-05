<?php

declare(strict_types=1);

namespace App\Model\Product\Command\Add;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    public string $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    public string $description;

    /**
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    public float $price;


    public string $categoryId;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('categoryId', new Assert\NotBlank());
        $metadata->addPropertyConstraint('categoryId', new Assert\Uuid());
    }

    /*public function validate()
    {
        //uuid +
        //isFloat +-
        // https://symfony.com/doc/current/components/validator/resources.html id через это

        if (empty($this->categoryId)) {
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
    }*/
}
