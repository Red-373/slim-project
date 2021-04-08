<?php

declare(strict_types=1);

namespace App\Model\Tag\Command\Add;

use App\Infrastructure\Doctrine\Flusher\Flusher;
use App\Model\Tag\Entity\Tag;
use App\Model\Tag\Entity\TagRepository;
use App\Model\Tag\Type\NameTagType;
use DomainException;

class Handler
{
    private TagRepository $tagRepository;
    private Flusher $flusher;

    public function __construct(TagRepository $tagRepository, Flusher $flusher)
    {
        $this->tagRepository = $tagRepository;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $name = $command->name;

        $tagName = new NameTagType($name);

        if ($this->tagRepository->hasTagByName($tagName)) {
            throw new DomainException('Tag already set!');
        }

        $tag = new Tag($tagName);

        $this->tagRepository->addTag($tag);

        $this->flusher->flush();
    }
}