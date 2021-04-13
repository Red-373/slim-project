<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Add;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Category\Entity\Category;
use App\Model\Category\Entity\CategoryRepository;
use App\Model\Category\Type\NameCategoryType;
use App\Model\Type\UuidType;
use DomainException;

class Handler
{
    private CategoryRepository $repository;
    private Flusher $flusher;

    public function __construct(CategoryRepository $repository, Flusher $flusher)
    {
        $this->repository = $repository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $category = new Category(UuidType::generate(), new NameCategoryType($command->name));

        if ($this->repository->hasByName($category->getName())) {
            throw new DomainException('Category already set!');
        }

        $this->repository->add($category);

        $this->flusher->flush();
    }
}
