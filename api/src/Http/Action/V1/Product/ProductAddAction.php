<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Product;

use App\Http\JsonResponse;
use App\Model\Product\Command\Add\Command;
use App\Model\Product\Command\Add\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductAddAction implements RequestHandlerInterface
{
    private Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $command = new Command();
        $command->id = $data['category_id'] ?? '';
        $command->name = $data['name'] ?? '';
        $command->price = (float) $data['price'] ?? '';
        $command->description = $data['description'] ?? '';
        $command->validate();

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
