<?php

namespace App\Repository;

use App\Entity\Citi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Citi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Citi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Citi[]    findAll()
 * @method Citi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Citi::class);
    }

    // /**
    //  * @return Citi[] Returns an array of Citi objects
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
    public function findOneBySomeField($value): ?Citi
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
