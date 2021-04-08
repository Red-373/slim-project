<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Tag;

use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\Infrastructure\Exception\TypeErrorException;
use App\Model\Tag\Command\Tag\Command;
use App\ReadModel\Tag\TagFetcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TypeError;

class TagAction implements RequestHandlerInterface
{
    private TagFetcher $fetcher;
    private Validator $validator;

    public function __construct(TagFetcher $fetcher, Validator $validator)
    {
        $this->fetcher = $fetcher;
        $this->validator = $validator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getQueryParams();

        $command = new Command();

        try {
            $command->id = $data['id'] ?? '';
        } catch (TypeError $e) {
            throw new TypeErrorException($e->getMessage(), $e->getCode(), $e);
        }

        $this->validator->validate($command);

        $category = $this->fetcher->getTag($command);

        return new JsonResponse($category);
    }
}