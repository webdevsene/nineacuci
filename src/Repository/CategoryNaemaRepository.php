<?php

namespace App\Repository;

use App\Entity\CategoryNaema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryNaema|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryNaema|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryNaema[]    findAll()
 * @method CategoryNaema[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryNaemaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryNaema::class);
    }

    // /**
    //  * @return CategoryNaema[] Returns an array of CategoryNaema objects
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
    public function findOneBySomeField($value): ?CategoryNaema
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
