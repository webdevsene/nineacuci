<?php

namespace App\Repository;

use App\Entity\TypeNINEA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeNINEA|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeNINEA|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeNINEA[]    findAll()
 * @method TypeNINEA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeNINEARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeNINEA::class);
    }

    // /**
    //  * @return TypeNINEA[] Returns an array of TypeNINEA objects
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
    public function findOneBySomeField($value): ?TypeNINEA
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
