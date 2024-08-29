<?php

declare(strict_types=1);

namespace App\Cqrs\Query\Word;

use App\Cqrs\QueryHandler;
use App\Entity\Word;
use App\Repository\WordRepository;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class GetWordHandler  implements QueryHandler
{
    public function __construct(
        private readonly WordRepository $repository,
        private readonly SerializerInterface $serializer
    ) { }

    public function __invoke(GetWord $query): string
    {
         $word = $this->repository->find($query->id);

         return $this->serializer->serialize(
             $word,
             JsonEncoder::FORMAT,
             [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]
         );
    }
}