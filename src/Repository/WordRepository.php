<?php

namespace App\Repository;

use App\Cqrs\Command\Word\AddWord;
use App\Cqrs\Command\Word\EditWord;
use App\Entity\Word;
use App\Mappers\WordMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Word>
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager,
        private readonly WordMapper $wordMapper
    )
    {
        parent::__construct($registry, Word::class);
    }

    public function add(AddWord $addWord): Word
    {
        $wordEntity = new Word();
        $wordEntity = $this->wordMapper->mapDtoToEntity($addWord, $wordEntity);
        $this->entityManager->persist($wordEntity);
        $this->entityManager->flush();

        return $wordEntity;
    }

    public function edit(EditWord $editWord): Word
    {
        $wordEntity = $this->findOneBy(['id' => $editWord->id]);

        if (!$wordEntity) {
            throw new \Exception('Word with id ' . $editWord->id . ' not found');
        }

        $wordEntity = $this->wordMapper->mapDtoToEntity($editWord, $wordEntity);
        $this->entityManager->persist($wordEntity);
        $this->entityManager->flush();

        return $wordEntity;
    }

    public function remove(int $id): void
    {
        $wordEntity = $this->find($id);
        if ($wordEntity === null) {
            throw new \Exception('Word not found');
        }
        $this->entityManager->remove($wordEntity);
        $this->entityManager->flush();

    }
}
