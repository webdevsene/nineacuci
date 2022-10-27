<?php

namespace App\Repository;

use App\Entity\NiStatut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NiStatut|null find($id, $lockMode = null, $lockVersion = null)
 * @method NiStatut|null findOneBy(array $criteria, array $orderBy = null)
 * @method NiStatut[]    findAll()
 * @method NiStatut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NiStatutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NiStatut::class);
    }

    // /**
    //  * @return NiStatut[] Returns an array of NiStatut objects
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
    public function findOneBySomeField($value): ?NiStatut
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
