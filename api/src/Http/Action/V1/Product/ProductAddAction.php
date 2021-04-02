<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Product;

use App\Http\JsonResponse;
use App\Model\Product\Command\Add\Command;
use App\Model\Product\Command\Add\Handler;
use App\ReadModel\Category\CategoryFetcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductAddAction implements RequestHandlerInterface
{
    private Handler $handler;
    private CategoryFetcher $fetcher;

    public function __construct(Handler $handler, CategoryFetcher $fetcher)
    {
        $this->handler = $handler;
        $this->fetcher = $fetcher;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $categoryId = $data['category_id'] ?? '';
        $name = $data['name'] ?? '';
        $price = $data['price'] ?? '';
        $description = $data['description'] ?? '';

        $command = new Command();
        $command->id = $categoryId;
        $command->name = $name;
        $command->price = (float) $price;
        $command->description = $description;
        $command->validate();

        $category = $this->fetcher->findProductCategory($command);
        $command->category = $category;

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
