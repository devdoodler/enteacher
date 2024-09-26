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


    //    /**
    //     * @return Translation[] Returns an array of Translation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Translation
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
