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
        $productName = new NameType($command->name);
        $description = new DescriptionType($command->description);
        $price =  new PriceType($command->price);
        $category = $this->categoryRepository->getCategory(new UuidType($command->categoryId));

        if ($this->repository->hasProductByName($productName)) {
            throw new LogicException('Product already set!');
        }

        $product = new Product(
            $productName,
            $description,
            $price,
            $category
        );

        $this->repository->addProduct($product);

        $this->flusher->flush();
    }
}
