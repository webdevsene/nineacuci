<?php

namespace App\Repository;

use App\Entity\CompteurNINEA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompteurNINEA|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteurNINEA|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteurNINEA[]    findAll()
 * @method CompteurNINEA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteurNINEARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteurNINEA::class);
    }

    // /**
    //  * @return CompteurNINEA[] Returns an array of CompteurNINEA objects
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
    public function findOneBySomeField($value): ?CompteurNINEA
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
