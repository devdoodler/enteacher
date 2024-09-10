<?php

declare(strict_types=1);

namespace App\Cqrs\Query\Word;

use App\Cqrs\QueryHandler;
use App\Mappers\PronunciationMapper;
use App\Repository\PronunciationRepository;

final readonly class GetPronunciationHandler  implements QueryHandler
{
    public function __construct(
        private PronunciationRepository $repository,
        private PronunciationMapper $pronunciationMapper
    ) { }

    public function __invoke(GetPronunciation $query): string
    {
         return $this->pronunciationMapper->mapEntityToJson($this->repository->find($query->id));
    }
}