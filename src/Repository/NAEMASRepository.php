<?php

namespace App\Repository;

use App\Entity\NAEMAS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NAEMAS|null find($id, $lockMode = null, $lockVersion = null)
 * @method NAEMAS|null findOneBy(array $criteria, array $orderBy = null)
 * @method NAEMAS[]    findAll()
 * @method NAEMAS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NAEMASRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NAEMAS::class);
    }

    // /**
    //  * @return NAEMAS[] Returns an array of NAEMAS objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NAEMAS
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
