<?php

declare(strict_types=1);

namespace App\Cqrs\Command\Translation;

use App\Cqrs\CommandHandler;
use App\Repository\TranslationRepository;

final readonly class RemoveTranslationHandler implements CommandHandler
{
    public function __construct(private TranslationRepository $repository) { }

    public function __invoke(RemoveTranslation $command): void
    {
        $this->repository->remove($command->id);
    }
}
