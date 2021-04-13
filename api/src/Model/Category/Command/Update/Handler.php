<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Update;

use App\Infrastructure\Doctrine\Flusher\Flusher;
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
        $categoryId = new UuidType($command->id);

        if (!$this->repository->has($categoryId)) {
            throw new DomainException('Not found category for id = ' . $categoryId->getValue() . '.');
        }

        $category = $this->repository->getCategory($categoryId);

        $category->changeName(new NameCategoryType($command->name));

        $this->flusher->flush();
    }
}
