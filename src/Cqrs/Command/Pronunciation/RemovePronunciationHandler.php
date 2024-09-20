<?php

declare(strict_types=1);

namespace App\Cqrs\Command\Pronunciation;

use App\Cqrs\CommandHandler;
use App\Repository\PronunciationRepository;
use App\Service\FileService;

final readonly class RemovePronunciationHandler implements CommandHandler
{
    private const PATH = 'voice';

    public function __construct(
        private PronunciationRepository $repository,
        private FileService $fileService
    ) { }

    public function __invoke(RemovePronunciation $command): void
    {
        $pronunciation = $this->repository->find($command->id);

        if (null === $pronunciation) {
            return;
        }

        $fileName = $this->repository->find($command->id)->getPath();
        $this->repository->remove($command->id);

        if ($fileName) {
            $this->fileService->cleanFile(self::PATH, $fileName);
        }
    }
}
