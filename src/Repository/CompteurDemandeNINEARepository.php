<?php

namespace App\Repository;

use App\Entity\CompteurDemandeNINEA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompteurDemandeNINEA|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteurDemandeNINEA|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteurDemandeNINEA[]    findAll()
 * @method CompteurDemandeNINEA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteurDemandeNINEARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteurDemandeNINEA::class);
    }

    // /**
    //  * @return CompteurDemandeNINEA[] Returns an array of CompteurDemandeNINEA objects
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
    public function findOneBySomeField($value): ?CompteurDemandeNINEA
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
