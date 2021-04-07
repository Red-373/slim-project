<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Product\Attach;

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
            throw new DomainException('Not found category id = ' . $categoryId->getValue() . '.');
        }

        $category = $this->repository->getCategory($categoryId);

        foreach ($products as $productId) {
            $productUuid = new UuidType($productId);
            if (!$this->productRepository->has($productUuid)) {
                throw new DomainException('Not found product. Product id = ' . $productUuid->getValue() . '.' );
            }

            $product = $this->productRepository->getProduct($productUuid);

            if ($product->hasCategory()) {
                throw new DomainException('This product ' . $product->getId()->getValue() . ' have category id.');
            }
            // Зависимая сторона Mappedby (mapped by category(сопоставлено по категориям))
            // Сторона владелец inversedBy (inversed by products(перевернутый по продукту))
            $product->changeCategory($category);
        }

        $this->flusher->flush();
    }
}
