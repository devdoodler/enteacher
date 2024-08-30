<?php

declare(strict_types=1);

namespace App\Cqrs\Query\Word;

use App\Cqrs\QueryHandler;
use App\Mappers\WordMapper;
use App\Repository\WordRepository;

final readonly class GetWordHandler  implements QueryHandler
{
    public function __construct(
        private WordRepository $repository,
        private WordMapper $wordMapper
    ) { }

    public function __invoke(GetWord $query): string
    {
         return $this->wordMapper->mapEntityToJson($this->repository->find($query->id));
    }
}