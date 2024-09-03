<?php

declare(strict_types=1);

namespace App\Cqrs\Command\Pronunciation;

use App\Cqrs\CommandHandler;
use App\Repository\PronunciationRepository;

final readonly class AddPronunciationHandler implements CommandHandler
{
    public function __construct(private PronunciationRepository $repository) { }

    public function __invoke(AddPronunciation $command): void
    {
        $this->repository->add($command);
    }
}
