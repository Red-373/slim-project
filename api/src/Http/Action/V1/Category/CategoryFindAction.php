<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Category;

use App\Http\JsonResponse;
use App\Model\Category\Command\Find\Command;
use App\ReadModel\Category\CategoryFetcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CategoryFindAction implements RequestHandlerInterface
{
    private CategoryFetcher $fetcher;

    public function __construct(CategoryFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $name = $data['name'] ?? '';

        $command = new Command();
        $command->name = $name;
        $command->validate();

        $category = $this->fetcher->findCategoryByName($command);

        return new JsonResponse($category);
    }
}
