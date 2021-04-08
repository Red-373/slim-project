<?php

declare(strict_types=1);

namespace App\Model\Tag\Command\Product\Attach;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     * @Assert\Uuid()
     */
    public string $id;

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