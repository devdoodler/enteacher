<?php

declare(strict_types=1);

namespace App\Cqrs\Command\Word;

use App\Cqrs\CommandHandler;
use App\Repository\WordRepository;

final readonly class AddWordHandler implements CommandHandler
{
    public function __construct(private WordRepository $repository) { }

    public function __invoke(AddWord $command): void
    {
        $this->repository->add($command);
    }
}
