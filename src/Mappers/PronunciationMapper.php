<?php

namespace App\Mappers;
use App\Cqrs\Command\Pronunciation\AddPronunciation;
use App\Entity\Pronunciation;
use App\Enum\DialectEnum;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

readonly class PronunciationMapper
{
    public function __construct(
        private SerializerInterface $serializer
    ) { }

    public function mapDtoToEntity(AddPronunciation $command, Pronunciation $entity): Pronunciation
    {
        $dialect = DialectEnum::tryFrom($command->dialect);
        if ($dialect === null) {
            throw new \Exception('Wrong Dialect');
        }
        $entity->setDialect($dialect);
        $entity->setSource($command->source);
        $entity->setPath($command->path);
        if ($command->phonetically) {
            $entity->setPhonetically($command->phonetically);
        };

        return $entity;
    }

    public function mapEntityToJson(Pronunciation $entity): string
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
}
