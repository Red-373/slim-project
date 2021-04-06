<?php

declare(strict_types=1);

namespace App\Model\Product\Command\Add;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Category\Entity\CategoryRepository;
use App\Model\Product\Entity\Product;
use App\Model\Product\Entity\ProductRepository;
use App\Model\Product\Type\DescriptionType;
use App\Model\Product\Type\NameType;
use App\Model\Product\Type\PriceType;
use App\Model\Type\UuidType;
use LogicException;

class Handler
{
    private CategoryRepository $categoryRepository;
    private ProductRepository $repository;
    private Flusher $flusher;

    public function __construct(CategoryRepository $categoryRepository, ProductRepository $repository, Flusher $flusher)
    {
        $this->categoryRepository = $categoryRepository;
        $this->repository = $repository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $name = $command->name;
        $description = $command->description;
        $price = $command->price;

        $productName = new NameType($name);
        $productDescription = new DescriptionType($description);
        $productPrice = new PriceType($price);
        $categoryId = !empty($command->categoryId) ? new UuidType($command->categoryId) : null;

        $category = null;

        if ($categoryId) {
            $category = $this->categoryRepository->getCategory($categoryId);
        }

        if ($this->repository->hasProductByName($productName)) {
            throw new LogicException('Product already set!');
        }

        $product = new Product(
            $productName,
            $productDescription,
            $productPrice,
            $category
        );

        $this->repository->addProduct($product);

        $this->flusher->flush();
    }
}
