<?php

namespace App\Repository;

use App\Cqrs\Command\Translation\AddTranslation;
use App\Entity\Translation;
use App\Entity\WordTranslation;
use App\Mappers\TranslationMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Translation>
 */
class TranslationRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslationMapper $translationMapper,
        private readonly WordRepository $wordRepository,
        private readonly WordTranslationRepository $wordTranslationRepository
    )
    {
        parent::__construct($registry, Translation::class);
    }

    public function add(AddTranslation $addTranslation): Translation
    {
        $entity = new Translation();
        $entity = $this->translationMapper->mapDtoToEntity($addTranslation, $entity);
        $word = $this->wordRepository->find($addTranslation->wordId);
        $wordTranslation = new WordTranslation();
        $wordTranslation->setWord($word);
        $wordTranslation->setTranslation($entity);
        $wordTranslation->setPriority(0);

        $this->entityManager->persist($entity);
        $this->entityManager->persist($wordTranslation);
        $this->entityManager->flush();

        return $entity;
    }

    public function remove(int $id): void
    {
        $translationEntity = $this->find($id);
        if ($translationEntity === null) {
            throw new \Exception('Translation not found');
        }
        $wordTranslations = $this->wordTranslationRepository->findBy([
            'Translation' => $translationEntity->getId(),
        ]);
        foreach ($wordTranslations as $wordTranslation) {
            $this->entityManager->remove($wordTranslation);
        }
        $this->entityManager->remove($translationEntity);
        $this->entityManager->flush();
    }
}
