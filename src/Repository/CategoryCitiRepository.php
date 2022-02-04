<?php

namespace App\Repository;

use App\Entity\CategoryCiti;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryCiti|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryCiti|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryCiti[]    findAll()
 * @method CategoryCiti[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryCitiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryCiti::class);
    }

    // /**
    //  * @return CategoryCiti[] Returns an array of CategoryCiti objects
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
    public function findOneBySomeField($value): ?CategoryCiti
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
