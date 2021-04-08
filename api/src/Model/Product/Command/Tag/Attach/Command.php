<?php

declare(strict_types=1);

namespace App\Model\Product\Command\Tag\Attach;

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
    public array $tags;
}
