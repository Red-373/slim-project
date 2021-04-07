<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Category;

use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\Infrastructure\Exception\TypeErrorException;
use App\Model\Category\Command\Update\Command;
use App\Model\Category\Command\Update\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TypeError;

class CategoryUpdateAction implements RequestHandlerInterface
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

        try {
            $command->name = $data['name'] ?? '';
            $command->id = $data['id'] ?? '';
        } catch (TypeError $e) {
            throw new TypeErrorException($e->getMessage(), $e->getCode(), $e);
        }

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
