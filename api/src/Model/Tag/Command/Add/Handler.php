<?php

declare(strict_types=1);

namespace App\Model\Tag\Command\Add;

/*use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Type\UuidType;
use DomainException;

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
            throw new DomainException('Product already set!');
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
}*/