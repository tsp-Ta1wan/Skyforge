<?php

namespace App\Repository;

use App\Entity\Hall;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hall>
 */
class HallRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hall::class);
    }

    /**
     * Finds all published halls.
     *
     * @return Hall[] Returns an array of Hall objects where 'published' is true.
     */
    public function findPublished(): array
    {
        return $this->findBy(['published' => true]);
    }
}
