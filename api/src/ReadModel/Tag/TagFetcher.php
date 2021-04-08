<?php

declare(strict_types=1);

namespace App\ReadModel\Tag;

use App\Model\Tag\Command\Tag\Command;
use App\Model\Tag\Entity\Tag;
use App\Model\Tag\Entity\TagRepository;
use App\Model\Type\UuidType;

class TagFetcher
{
    private TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getTag(Command $command): array
    {
        $tagId = new UuidType($command->id);

        $product = $this->repository->getTag($tagId);

        return $this->convertCategoryToArray($product);
    }

    private function convertCategoryToArray(Tag $tag): array
    {
        $data = [
            'id' => $tag->getId()->getValue(),
            'products' => []
        ];

        foreach ($tag->getProducts() as $product) {
            $data['products'][] = [
                'name' => $product->getName()->getValue(),
                'price' => $product->getPrice()->getValue(),
                'description' => $product->getDescription()->getValue(),
                'id' => $product->getId()->getValue(),
            ];
        }

        return $data;
    }
}