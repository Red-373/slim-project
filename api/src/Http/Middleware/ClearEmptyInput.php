<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ClearEmptyInput
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $request
            ->withParsedBody(self::filterStrings($request->getParsedBody()))
            ->withUploadedFiles(self::filterFiles($request->getUploadedFiles()));

        return $handler->handle($request);
    }

    private static function filterStrings($items)
    {
        if (!is_array($items)) {
            return $items;
        }

        $result = [];

        foreach ($items as $key => $item) {
            if (is_string($item)) {
                $result[$key] = trim($item);
            } else {
                $result[$key] = self::filterStrings($item);
            }
        }

        return $result;
    }

    private static function filterFiles(array $items): array
    {
        $result = [];

        foreach ($items as $key => $item) {
            if ($item instanceof UploadedFileInterface) {
                if ($item->getError() !== UPLOAD_ERR_NO_FILE) {
                    $result[$key] = $item;
                }
            } else {
                $result[$key] = self::filterFiles($item);
            }
        }

        return $result;
    }
}