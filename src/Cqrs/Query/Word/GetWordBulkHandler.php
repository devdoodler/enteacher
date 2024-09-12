<?php

declare(strict_types=1);

namespace App\Cqrs\Query\Word;

use App\Cqrs\QueryHandler;
use App\Mappers\WordMapper;
use App\Repository\WordRepository;

final readonly class GetWordBulkHandler  implements QueryHandler
{
    public function __construct(
        private WordRepository $repository,
        private WordMapper $wordMapper
    ) { }

    public function __invoke(GetWordBulk $query): string
    {
         return $this->wordMapper->mapBulkEntityToJson($this->repository->findAll());
    }
}