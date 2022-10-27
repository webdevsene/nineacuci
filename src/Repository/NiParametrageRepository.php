<?php

namespace App\Repository;

use App\Entity\NiParametrage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiParametrage|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiParametrage|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiParametrage[]    findAll()
 * @method NiParametrage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiParametrageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiParametrage::class);
    }

    // /**
    //  * @return NiParametrage[] Returns an array of NiParametrage objects
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
    public function findOneBySomeField($value): ?NiParametrage
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
