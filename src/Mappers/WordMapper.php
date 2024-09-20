<?php

namespace App\Mappers;
use App\Cqrs\Command\Word\AddWord;
use App\Cqrs\Command\Word\EditWord;
use App\Entity\Word;
use App\Enum\DialectEnum;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

readonly class WordMapper
{
    public function __construct(
        private SerializerInterface $serializer,
        private NormalizerInterface $normalizer
    ) { }

    public function mapDtoToEntity(AddWord|EditWord $command, Word $entity): Word
    {

        $entity->setName($command->name);
        $dialect = DialectEnum::tryFrom($command->dialect);
        if ($dialect === null) {
            throw new \Exception('Wrong Dialect');
        }
        $entity->setDialect($dialect);
        if ($command->explanation) {
            $entity->setExplanation($command->explanation);
        }
        if ($command->pronunciation) {
            $entity->setPronunciation($command->pronunciation);
        }

        return $entity;
    }

    public function mapEntityToJson(Word $entity): string
    {
        $normalized = $this->serializer->normalize(
            $entity,
            null,
            [
                ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER =>
                    function ($object) {
                        return $object->getId();
                    }
            ]
        );

        return $this->serializer->serialize(
            $normalized,
            JsonEncoder::FORMAT,
            [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]
        );
    }

    public function mapBulkEntityToJson(array $wordEntityArray): string
    {
        $normalizedWordEntity = [];
        foreach ($wordEntityArray as $wordEntity) {
            $normalizedWordEntity[] = $this->normalizer->normalize(
                $wordEntity,
                JsonEncoder::FORMAT,
                [
                    ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER =>
                    function ($object) {
                        return $object->getId();
                    },
                    JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
                ]
            );
        }

        return $this->serializer->serialize(
            $normalizedWordEntity,
            JsonEncoder::FORMAT,
            [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT]
        );
    }
}
