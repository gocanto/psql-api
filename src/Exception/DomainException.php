<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Exception;

use Exception;
use Throwable;

class DomainException extends Exception
{
    public static function fromThrowable(Throwable $throwable): self
    {
        return new self($throwable->getMessage(), $throwable->getCode(), $throwable);
    }
}