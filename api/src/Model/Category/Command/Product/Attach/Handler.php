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
    private CategoryRepository $categoryRepository;
    private ProductRepository $productRepository;
    private Flusher $flusher;

    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository, Flusher $flusher)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $categoryId = new UuidType($command->id);
        $products = $command->products;

        if (!$this->categoryRepository->has($categoryId)) {
            throw new DomainException('Not found category id = ' . $categoryId->getValue() . '.');
        }

        $category = $this->categoryRepository->getCategory($categoryId);

        foreach ($products as $productId) {
            $productUuid = new UuidType($productId);
            if (!$this->productRepository->has($productUuid)) {
                throw new DomainException('Not found product. Product id = ' . $productUuid->getValue() . '.');
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
