<?php

declare(strict_types=1);

namespace App\ReadModel\Product;

use App\Model\Product\Command\Product\Command;
use App\Model\Product\Entity\Product;
use App\Model\Product\Entity\ProductRepository;
use App\Model\Type\UuidType;

class ProductFetcher
{
    private ProductRepository $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getProduct(Command $command): array
    {
        $productId = new UuidType($command->id);

        $product = $this->repository->getProduct($productId);

        return $this->convertCategoryToArray($product);
    }

    private function convertCategoryToArray(Product $product): array
    {
        $data = [
            'id' => $product->getId()->getValue(),
            'name' => $product->getName()->getValue(),
            'description' => $product->getDescription()->getValue(),
            'price' => $product->getPrice()->getValue(),
            'category_id' => !empty($product->getCategory()) ? $product->getCategory()->getId()->getValue() : null
        ];

        return $data;
    }
}
