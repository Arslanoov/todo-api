<?php

declare(strict_types=1);

namespace Domain\Model\Exception;

use DomainException as BaseDomainException;
use Throwable;

class DomainException extends BaseDomainException
{
    public function __construct(string $message = "", int $code = 409, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
