<?php

namespace App\Repository;

use App\Entity\TypeBilan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeBilan|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeBilan|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeBilan[]    findAll()
 * @method TypeBilan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeBilanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeBilan::class);
    }

    // /**
    //  * @return TypeBilan[] Returns an array of TypeBilan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeBilan
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
