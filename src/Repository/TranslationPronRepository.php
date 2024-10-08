<?php

namespace App\Repository;

use App\Entity\TranslationPron;
use App\Mappers\TranslationMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TranslationPron>
 */
class TranslationPronRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, TranslationPron::class);
    }
}
