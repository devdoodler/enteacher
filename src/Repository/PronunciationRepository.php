<?php

namespace App\Repository;

use App\Cqrs\Command\Pronunciation\AddPronunciation;
use App\Entity\Pronunciation;
use App\Mappers\PronunciationMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pronunciation>
 */
class PronunciationRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager,
        private readonly PronunciationMapper $pronunciationMapper,
        private readonly WordRepository $wordRepository
    ) {
        parent::__construct($registry, Pronunciation::class);
    }

    public function add(AddPronunciation $addPronunciation): Pronunciation
    {
        $entity = new Pronunciation();
        $entity = $this->pronunciationMapper->mapDtoToEntity($addPronunciation, $entity);
        $this->wordRepository->find($addPronunciation->wordId)->addPronunciation($entity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}
