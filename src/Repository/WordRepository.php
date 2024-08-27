<?php

namespace App\Repository;

use App\Cqrs\Command\Word\AddWord;
use App\Entity\Word;
use App\Enum\DialectEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use function PHPUnit\Framework\throwException;

/**
 * @extends ServiceEntityRepository<Word>
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Word::class);
    }
    public function add(AddWord $addWord): Word
    {
        $wordEntity = new Word();
        $wordEntity->setName($addWord->name);
        $dialect = DialectEnum::tryFrom($addWord->dialect);
        if ($dialect === null) {
            throw new \Exception('Wrong Dialect');
        }
        $wordEntity->setDialect($dialect);
        if ($addWord->explanation) {
            $wordEntity->setExplanation($addWord->explanation);
        }
        if ($addWord->pronunciation) {
            $wordEntity->setPronunciation($addWord->pronunciation);
        }

        $this->entityManager->persist($wordEntity);
        $this->entityManager->flush();

        return $wordEntity;
    }
}
