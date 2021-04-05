<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Update;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Category\Entity\CategoryRepository;
use App\Model\Category\Type\NameType;
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
        $categoryId = $command->id;

        $category = $this->repository->getCategory(new UuidType($categoryId));

        if (!$category) {
            throw new DomainException('No found category for id' . $categoryId);
        }

        $category->changeName(new NameType($command->name));

        $this->flusher->flush();
    }
}