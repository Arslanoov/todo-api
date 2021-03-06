<?php

declare(strict_types=1);

namespace Domain\Model\Exception\Person;

use Domain\Model\Exception\DomainException;
use Throwable;

final class BackgroundPhotoNotFound extends DomainException
{
    public function __construct(
        string $message = "Background photo not found.",
        int $code = 404,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
