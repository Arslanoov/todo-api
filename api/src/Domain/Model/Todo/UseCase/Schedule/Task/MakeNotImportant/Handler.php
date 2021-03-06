<?php

declare(strict_types=1);

namespace Domain\Model\Todo\UseCase\Schedule\Task\MakeNotImportant;

use Domain\Model\Todo\Entity\Schedule\Task\Id;
use Domain\Model\Todo\Entity\Schedule\Task\TaskRepository;
use Domain\Model\FlusherInterface;

final class Handler
{
    private TaskRepository $tasks;
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     * @param TaskRepository $tasks
     * @param FlusherInterface $flusher
     */
    public function __construct(TaskRepository $tasks, FlusherInterface $flusher)
    {
        $this->tasks = $tasks;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $task = $this->tasks->getById(new Id($command->taskId));

        $task->makeNotImportant();

        $this->flusher->flush();
    }
}
