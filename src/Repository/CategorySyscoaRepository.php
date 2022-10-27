<?php

namespace App\Repository;

use App\Entity\CategorySyscoa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorySyscoa|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorySyscoa|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorySyscoa[]    findAll()
 * @method CategorySyscoa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorySyscoaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorySyscoa::class);
    }

    // /**
    //  * @return CategorySyscoa[] Returns an array of CategorySyscoa objects
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
    public function findOneBySomeField($value): ?CategorySyscoa
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
