<?php

namespace App\Repository;

use App\Entity\SYSCOA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SYSCOA|null find($id, $lockMode = null, $lockVersion = null)
 * @method SYSCOA|null findOneBy(array $criteria, array $orderBy = null)
 * @method SYSCOA[]    findAll()
 * @method SYSCOA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SYSCOARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SYSCOA::class);
    }

    // /**
    //  * @return SYSCOA[] Returns an array of SYSCOA objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SYSCOA
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
