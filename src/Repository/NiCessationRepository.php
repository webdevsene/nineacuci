<?php

namespace App\Repository;

use App\Entity\NiCessation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiCessation|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiCessation|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiCessation[]    findAll()
 * @method NiCessation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiCessationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiCessation::class);
    }

    // /**
    //  * @return NiCessation[] Returns an array of NiCessation objects
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
    public function findOneBySomeField($value): ?NiCessation
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
