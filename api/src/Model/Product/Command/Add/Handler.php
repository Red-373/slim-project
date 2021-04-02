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
        $category = $this->categoryRepository->getCategory(new UuidType($command->id));

        $product = new Product(
            UuidType::generate(),
            new NameType($command->name),
            new DescriptionType($command->description),
            new PriceType($command->price),
            $category
        );

        if ($this->repository->has($product)) {
            throw new LogicException('Product already set!');
        }

        $this->repository->addProduct($product);

        $this->flusher->flush();
    }
}
