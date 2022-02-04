<?php

namespace App\Repository;

use App\Entity\QVH;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QVH|null find($id, $lockMode = null, $lockVersion = null)
 * @method QVH|null findOneBy(array $criteria, array $orderBy = null)
 * @method QVH[]    findAll()
 * @method QVH[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QVHRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QVH::class);
    }

    // /**
    //  * @return QVH[] Returns an array of QVH objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QVH
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
