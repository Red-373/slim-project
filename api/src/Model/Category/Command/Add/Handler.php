<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Add;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Category\Entity\Category;
use App\Model\Category\Entity\CategoryRepository;
use App\Model\Category\Type\NameType;
use App\Model\Type\UuidType;
use LogicException;

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
        $category = new Category(UuidType::generate(), new NameType($command->name));

        if ($this->repository->has($category)) {
            throw new LogicException('Category already set!');
        }

        $this->repository->addCategory($category);

        $this->flusher->flush();
    }
}