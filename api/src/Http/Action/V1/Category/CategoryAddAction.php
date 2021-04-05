<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Category;

use App\Http\Exception\TypeErrorException;
use App\Http\JsonResponse;
use App\Model\Category\Command\Add\Command;
use App\Model\Category\Command\Add\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TypeError;

class CategoryAddAction implements RequestHandlerInterface
{
    private Handler $handler;
    private ValidatorInterface $validator;

    public function __construct(Handler $handler, ValidatorInterface $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $name = $data['name'] ?? '';

        $command = new Command();

        try {
            $command->name = $name;
        } catch (TypeError $e) {
            throw new TypeErrorException($e->getMessage(), $e->getCode());
        }

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new JsonResponse([]);
    }
}
