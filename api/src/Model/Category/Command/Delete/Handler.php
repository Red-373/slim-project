<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Delete;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Category\Entity\CategoryRepository;
use App\Model\Type\UuidType;
use DomainException;

class Handler
{
    private CategoryRepository $categoryRepository;
    private Flusher $flusher;

    public function __construct(CategoryRepository $categoryRepository, Flusher $flusher)
    {
        $this->categoryRepository = $categoryRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $categoryId = new UuidType($command->id);

        if (!$this->categoryRepository->has($categoryId)) {
            throw new DomainException('Not found category id = ' . $categoryId->getValue() . '.');
        }

        $category = $this->categoryRepository->getCategory($categoryId);

        $this->categoryRepository->remove($category);

        $this->flusher->flush();
    }
}
