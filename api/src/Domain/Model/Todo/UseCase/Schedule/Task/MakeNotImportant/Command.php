<?php

declare(strict_types=1);

namespace Domain\Model\Todo\UseCase\Schedule\Task\MakeNotImportant;

use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Uuid()
     */
    public string $taskId;

    /**
     * Command constructor.
     * @param string $taskId
     */
    public function __construct(string $taskId)
    {
        $this->taskId = $taskId;
    }
}
