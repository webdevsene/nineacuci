<?php

namespace App\Repository;

use App\Entity\Actionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Actionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actionnaire[]    findAll()
 * @method Actionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actionnaire::class);
    }

    // /**
    //  * @return Actionnaire[] Returns an array of Actionnaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Actionnaire
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
