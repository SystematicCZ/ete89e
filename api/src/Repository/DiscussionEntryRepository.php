<?php

namespace App\Repository;

use App\Entity\DiscussionEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DiscussionEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiscussionEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiscussionEntry[]    findAll()
 * @method DiscussionEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscussionEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscussionEntry::class);
    }

    // /**
    //  * @return DiscussionEntry[] Returns an array of DiscussionEntry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DiscussionEntry
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
