<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Product;

use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\Model\Product\Command\Add\Command;
use App\Model\Product\Command\Add\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductAddAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $command = new Command();
        $command->categoryId = $data['category_id'] ?? '';
        $command->name = $data['name'] ?? '';
        $command->price = $data['price'] ?? '';
        $command->description = $data['description'] ?? '';

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
