<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Detach;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\Type("array")
     * @Assert\Count(min=1)
     * @Assert\All(
     *     constraints={
     *          @Assert\NotBlank,
     *          @Assert\Uuid()
     *     }
     * )
     */
    public array $products;
}