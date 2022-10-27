<?php

namespace App\Repository;

use App\Entity\CategoryNaemas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryNaemas|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryNaemas|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryNaemas[]    findAll()
 * @method CategoryNaemas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryNaemasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryNaemas::class);
    }

    // /**
    //  * @return CategoryNaemas[] Returns an array of CategoryNaemas objects
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
    public function findOneBySomeField($value): ?CategoryNaemas
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
