<?php

declare(strict_types=1);

namespace App\Http\Action\V1\Product;

use App\Http\JsonResponse;
use App\Http\Validator\Validator;
use App\Infrastructure\Exception\TypeErrorException;
use App\Model\Product\Command\Product\Command;
use App\ReadModel\Product\ProductFetcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TypeError;

class ProductAction implements RequestHandlerInterface
{
    private ProductFetcher $fetcher;
    private Validator $validator;

    public function __construct(ProductFetcher $fetcher, Validator $validator)
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

        $category = $this->fetcher->getProduct($command);

        return new JsonResponse($category);
    }
}