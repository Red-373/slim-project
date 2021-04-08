<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Product;

use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\Infrastructure\Exception\TypeErrorException;
use App\Model\Product\Command\Tag\Attach\Command;
use App\Model\Product\Command\Tag\Attach\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TypeError;

class ProductAttachTagAction implements RequestHandlerInterface
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
            $command->id = $data['id'] ?? '';
            $command->tags = $data['tags'] ?? '';
        } catch (TypeError $e) {
            throw new TypeErrorException($e->getMessage(), $e->getCode(), $e);
        }

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
