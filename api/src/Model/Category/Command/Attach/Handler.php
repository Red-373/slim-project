<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Attach;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Category\Entity\CategoryRepository;
use App\Model\Product\Entity\ProductRepository;
use App\Model\Type\UuidType;
use DomainException;

class Handler
{
    private CategoryRepository $repository;
    private Flusher $flusher;
    private ProductRepository $productRepository;

    public function __construct(CategoryRepository $repository, Flusher $flusher, ProductRepository $productRepository)
    {
        $this->repository = $repository;
        $this->flusher = $flusher;
        $this->productRepository = $productRepository;
    }

    public function handle(Command $command): void
    {
        $categoryId = new UuidType($command->id);
        $products = $command->products;

        if (!$this->repository->has($categoryId)) {
            throw new DomainException('Not found category for id = ' . $categoryId->getValue() . '.');
        }

        $category = $this->repository->getCategory($categoryId);

        foreach ($products as $productId) {
            $productUuid = new UuidType($productId);
            if (!$this->productRepository->has($productUuid)) {
                throw new DomainException('Not found product.');
            }

            $product = $this->productRepository->getProduct($productUuid);

            if ($product->hasCategory($product)) {
                throw new DomainException('This product have category id.');
            }

            $category->addProduct($product);
        }

        $this->flusher->flush();
    }
}