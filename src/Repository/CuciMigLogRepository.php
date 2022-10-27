<?php

namespace App\Repository;

use App\Entity\CuciMigLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CuciMigLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuciMigLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuciMigLog[]    findAll()
 * @method CuciMigLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuciMigLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuciMigLog::class);
    }

    // /**
    //  * @return CuciMigLog[] Returns an array of CuciMigLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CuciMigLog
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
