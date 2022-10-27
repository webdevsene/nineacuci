<?php

namespace App\Repository;

use App\Entity\SystemeComptabilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SystemeComptabilite|null find($id, $lockMode = null, $lockVersion = null)
 * @method SystemeComptabilite|null findOneBy(array $criteria, array $orderBy = null)
 * @method SystemeComptabilite[]    findAll()
 * @method SystemeComptabilite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemeComptabiliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SystemeComptabilite::class);
    }

    // /**
    //  * @return SystemeComptabilite[] Returns an array of SystemeComptabilite objects
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
    public function findOneBySomeField($value): ?SystemeComptabilite
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
