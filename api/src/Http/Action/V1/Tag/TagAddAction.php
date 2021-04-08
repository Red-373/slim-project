<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Tag;

use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\Infrastructure\Exception\TypeErrorException;
use App\Model\Tag\Command\Add\Command;
use App\Model\Tag\Command\Add\Handler;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TypeError;

class TagAddAction implements RequestHandlerInterface
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
            $command->productId = $data['product'] ?? '';
        } catch (TypeError $e) {
            throw new TypeErrorException($e->getMessage(), $e->getCode(), $e);
        }

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
