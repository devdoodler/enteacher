<?php

namespace App\Mappers;
use App\Cqrs\Command\Translation\AddTranslation;
use App\Entity\Pronunciation;
use App\Entity\Translation;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

readonly class TranslationMapper
{
    public function __construct(
        private SerializerInterface $serializer
    ) { }

    public function mapDtoToEntity(AddTranslation $command, Translation $entity): Translation
    {
        $entity->setName($command->name);
        if ($command->explanation) {
            $entity->setExplanation($command->explanation);
        }

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
