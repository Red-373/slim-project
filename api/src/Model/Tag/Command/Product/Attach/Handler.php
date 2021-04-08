<?php

declare(strict_types=1);

namespace App\Model\Tag\Command\Product\Attach;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Product\Entity\ProductRepository;
use App\Model\Tag\Entity\TagRepository;
use App\Model\Type\UuidType;
use Doctrine\Common\Collections\ArrayCollection;
use DomainException;

class Handler
{
    private TagRepository $tagRepository;
    private Flusher $flusher;
    private ProductRepository $productRepository;

    public function __construct(TagRepository $tagRepository, Flusher $flusher, ProductRepository $productRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->flusher = $flusher;
        $this->productRepository = $productRepository;
    }

    public function handle(Command $command): void
    {
        $tagUuid = new UuidType($command->id);
        $products = $command->products;

        if (!$this->tagRepository->has($tagUuid)) {
            throw new DomainException('Not found tag. Tag id = ' . $tagUuid->getValue() . '.');
        }

        $tag = $this->tagRepository->getTag($tagUuid);
        $productsCollection = new ArrayCollection();

        foreach ($products as $productId) {
            $productUuid = new UuidType($productId);

            if (!$this->productRepository->has($productUuid)) {
                throw new DomainException('Not found product. Product id = ' . $productUuid->getValue() . '.');
            }

            $product = $this->productRepository->getProduct($productUuid);
            $productsCollection->add($product);
        }

        $tag->attachProducts($productsCollection);

        $this->flusher->flush();
    }
}