<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Product\Detach;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Category\Entity\CategoryRepository;
use App\Model\Product\Entity\ProductRepository;
use App\Model\Type\UuidType;
use DomainException;

class Handler
{
    private Flusher $flusher;
    private ProductRepository $productRepository;
    private CategoryRepository $repository;

    public function __construct(Flusher $flusher, ProductRepository $productRepository, CategoryRepository $repository)
    {
        $this->flusher = $flusher;
        $this->productRepository = $productRepository;
        $this->repository = $repository;
    }

    public function handle(Command $command): void
    {
        $categoryId = new UuidType($command->id);
        $products = $command->products;

        if (!$this->repository->has($categoryId)) {
            throw new DomainException('Not found category. Category id = ' . $categoryId->getValue() . '.');
        }

        foreach ($products as $productId) {
            $productUuid = new UuidType($productId);

            if (!$this->productRepository->has($productUuid)) {
                throw new DomainException('Not found product. Product id = ' . $productUuid->getValue() . '.');
            }
            $product = $this->productRepository->getProduct($productUuid);

            if (!$product->hasCategory()) {
                throw new DomainException(
                    'This product dont have category id. Product id = ' . $product->getId()->getValue() . '.'
                );
            }

            if ($product->getCategory()->getId()->getValue() !== $categoryId->getValue()) {
                throw new DomainException(
                    'This product does not match category. Category id = ' . $categoryId->getValue() . '.'
                );
            }

            $product->unsetCategory();
        }

        $this->flusher->flush();
    }
}
