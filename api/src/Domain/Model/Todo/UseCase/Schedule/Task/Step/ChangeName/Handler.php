<?php

declare(strict_types=1);

namespace Domain\Model\Todo\UseCase\Schedule\Task\Step\ChangeName;

use Domain\Model\Todo\Entity\Schedule\Task\Step\Id;
use Domain\Model\Todo\Entity\Schedule\Task\Step\Name;
use Domain\Model\Todo\Entity\Schedule\Task\Step\StepRepository;
use Domain\Model\FlusherInterface;

final class Handler
{
    private StepRepository $steps;
    private FlusherInterface $flusher;

    /**
     * Handler constructor.
     * @param StepRepository $steps
     * @param FlusherInterface $flusher
     */
    public function __construct(StepRepository $steps, FlusherInterface $flusher)
    {
        $this->steps = $steps;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $step = $this->steps->getById(new Id($command->stepId));

        $step->changeName(new Name($command->name));

        $this->flusher->flush();
    }
}
