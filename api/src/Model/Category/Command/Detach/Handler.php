<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Detach;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Product\Entity\ProductRepository;
use App\Model\Type\UuidType;
use DomainException;

class Handler
{
    private Flusher $flusher;
    private ProductRepository $productRepository;

    public function __construct(Flusher $flusher, ProductRepository $productRepository)
    {
        $this->flusher = $flusher;
        $this->productRepository = $productRepository;
    }

    public function handle(Command $command): void
    {
        $products = $command->products;

        foreach ($products as $productId) {
            $productUuid = new UuidType($productId);

            if (!$this->productRepository->has($productUuid)) {
                throw new DomainException('Not found product.');
            }
            $product = $this->productRepository->getProduct($productUuid);

            if (!$product->hasCategory()) {
                throw new DomainException('This product dont have category id. Product: ' . $product->getId()->getValue() . '.');
            }

            $product->unsetCategory();
        }

        $this->flusher->flush();
    }
}