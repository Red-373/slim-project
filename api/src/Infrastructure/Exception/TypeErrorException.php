<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

use TypeError;
use Throwable;

class TypeErrorException extends TypeError
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}