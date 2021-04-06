<?php

declare(strict_types=1);

namespace App\Model\Category\Command\Attach;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Category\Entity\CategoryRepository;

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

    }
}