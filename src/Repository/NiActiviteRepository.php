<?php

namespace App\Repository;

use App\Entity\NiActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiActivite|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiActivite|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiActivite[]    findAll()
 * @method NiActivite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiActivite::class);
    }

    // /**
    //  * @return NiActivite[] Returns an array of NiActivite objects
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
    public function findOneBySomeField($value): ?NiActivite
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
