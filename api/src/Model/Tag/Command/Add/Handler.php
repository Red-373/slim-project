<?php

declare(strict_types=1);

namespace App\Model\Tag\Command\Add;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Product\Entity\ProductRepository;
use App\Model\Tag\Entity\Tag;
use App\Model\Tag\Entity\TagRepository;
use App\Model\Tag\Type\NameTagType;
use App\Model\Type\UuidType;
use DomainException;

class Handler
{
    private TagRepository $tagRepository;
    private ProductRepository $productRepository;
    private Flusher $flusher;

    public function __construct(TagRepository $tagRepository, ProductRepository $productRepository, Flusher $flusher)
    {
        $this->tagRepository = $tagRepository;
        $this->flusher = $flusher;
        $this->productRepository = $productRepository;
    }

    public function handle(Command $command): void
    {
        $name = $command->name;
        $productId = $command->productId;

        $tagName = new NameTagType($name);

        if ($this->tagRepository->hasTagByName($tagName)) {
            throw new DomainException('Tag already set!');
        }

        $tag = new Tag($tagName);
        $this->tagRepository->addTag($tag);

        if ($productId) {
            $productUuid = new UuidType($productId);
            $product = $this->productRepository->getProduct($productUuid);

            $product->addTag($tag);
        }

        $this->flusher->flush();
    }
}